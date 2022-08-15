<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name'      => 'required|min:2|max:200',
            'phone'                 => 'required|digits:10|not_in:0|numeric',
            'email'                 => 'required|email|unique:users',
            'address'               => 'nullable|string|max:1000',
            'city'                  => 'required',
            'state'                 => 'required',
            'pin'                   => 'required|digits:6',
            'remarks'               => 'nullable|string|max:1000',
            'cp_name'               => 'required',
            'cp_email'              => 'required|email',
            'cp_phone'              => 'required|digits:10|not_in:0|numeric',
            'cp_designation'           => 'required'


        ];
    }
}
