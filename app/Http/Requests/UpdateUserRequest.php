<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateUserRequest extends Request
{
    public function rules()
    {
        $userId = $this->route('username')->id;

        return [
            'username' => [
                'bail',
                'alpha_num',
                'min:3',
                'max:20',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => [
                'bail',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => [
                'string',
                'min:5',
            ],
        ];
    }
}
