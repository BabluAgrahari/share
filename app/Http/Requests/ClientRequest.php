<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_no'       => 'required|min:2|max:200',
            'share_holder'  => 'required|string|min:2|max:200',
            'survivor_name' => 'required|string|min:2|max:200',
            'address'               => 'nullable|string|max:1000',
            'city'                  => 'required',
            'state'                 => 'required',
            'pin'                   => 'required|digits:6',
            'remarks'               => 'nullable|string|max:1000',
            'cp_name'               => 'required',
            'cp_email'              => 'required|email',
            'cp_mobile'              => 'required|digits:10|not_in:0|numeric'
            
        ];
    }
}
