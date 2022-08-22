<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FollowUpRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $rules = [
            'client_id'       => 'required|min:2|max:200',
            'follow_up_date'  => 'required',
            'follow_up_for'   => 'required',
            'remarks'         => 'required|min:3|max:5000',
        ];

        if ($request->follow_up_for == 'follow_up_user') {
            $rules['with_user_id'] = 'required';
        } else if ($request->follow_up_for == 'follow_up_with') {
            $rules['type']  = 'nullable|array';
            if (!empty($request->type)) {
                foreach ($request->type as $type) {

                    if ($type == 'company') {
                        $rules['company_id']    = 'nullable';
                        $rules['company_cp_id'] = 'nullable';
                    }
                    if ($type == 'agent') {
                        $rules['agent_id']    = 'nullable';
                        $rules['agent_cp_id'] = 'nullable';
                    }
                    if ($type == 'court') {
                        $rules['court_id']    = 'nullable';
                        $rules['court_cp_id'] = 'nullable';
                    }
                }
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'follow_up_date.required'   => 'Follow Up Date field is Required.',
            'type.required'             => 'Follow Up with field is required.',
            'company_id.required'       => 'Company field is required.',
            'agent_id.required'    => 'Agent field is Required.',
            'court_id.required'    => 'Court field is Required.',
            'cp_id.required'       => 'Please select a Contact Person',
            'remarks.required'     => 'Remarks field is Required.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException();
        throw new HttpResponseException(response(json_encode(array('validation' => $validator->errors()))));
    }
}
