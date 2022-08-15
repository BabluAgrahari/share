<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        return [
            'name'              => 'required|min:2|max:80',
            'mobile'            => 'required|digits:10|not_in:0|numeric',
            'email'             => ($request->isMethod('post')) ? 'required|email|unique:users,email' : 'required|email',
            'address'           => 'nullable|string|max:1000',
            'city'              => 'required',
            'state'             => 'required',
            'pin'               => 'required|digits:6|not_in:0|numeric',
            'password'          => ($request->isMethod('post')) ? 'required|min:6|max:16' : 'nullable',
            'confirm_password'  => ($request->isMethod('post')) ? 'required|min:6|max:16' : 'nullable',
            'role'              => 'required',


        ];
    }
}
