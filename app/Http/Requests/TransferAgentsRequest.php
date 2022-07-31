<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferAgentsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'agency_name'      => 'required|min:2|max:200',
            'phone' => 'required|string|min:2|max:200',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pin' => 'required'
            
        ];
    }
}
