<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'              => 'required|min:2|max:80',
            'mobile'            => 'required|digits:10|not_in:0|numeric',
            // 'email'             => 'required|email|unique:users,email,'.Rule::unique('users')->ignore($user->id),
            'address'           => 'nullable|string|max:1000',
            'city'              => 'required',
            'state'             => 'required',
            'pin'               => 'required|digits:6|not_in:0|numeric',
            'password'          => 'required|min:6|',
            'confirm_password'  => 'required|confirmed:password|min:6',
            'role'              => 'required',
            

        ];
    }
}
