<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class RequestLogin extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required|string'
        ];
    }

    /**
     * @return array|void
     */
    public function messages()
    {
        return [
            'email.exists' => 'User not found'
        ];
    }
}
