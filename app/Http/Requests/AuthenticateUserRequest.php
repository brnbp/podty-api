<?php
namespace App\Http\Requests;

class AuthenticateUserRequest extends Request
{
    public function rules()
    {
        return [
            'username' => 'bail|required|alpha_num|min:3|max:20',
            'password' => 'bail|required|string|min:5',
        ];
    }
}
