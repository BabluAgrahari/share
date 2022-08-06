<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourtRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'court_name'      => 'required|min:2|max:200',
            'address'               => 'nullable|string|max:1000',
            'city'                  => 'required',
            'state'                 => 'required',
            'pin'                   => 'required|digits:6',
            'cp_name'               => 'required',
            'cp_email'              => 'required|email',
            'cp_phone'              => 'required|digits:10|not_in:0|numeric'

            
        ];
    }
}
