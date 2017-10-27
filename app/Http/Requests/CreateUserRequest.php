<?php
namespace App\Http\Requests;

class CreateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'bail|required|alpha_num|unique:users|min:3|max:20',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|string|min:5',
        ];
    }
}
