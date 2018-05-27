<?php

namespace App\Http\Requests;

class CreateUserRequest extends Request
{
    public function rules()
    {
        return [
            'username' => 'bail|required|alpha_num|unique:users|min:3|max:20',
            'email'    => 'bail|required|email|unique:users',
            'password' => 'bail|required|string|min:5',
        ];
    }
}
