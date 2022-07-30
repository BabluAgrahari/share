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
            'file_no'      => 'required|min:2|max:200',
            'share_holder' => 'required|string|min:2|max:200',
            'surivor_name' => 'required|string|min:2|max:200'
        ];
    }
}
