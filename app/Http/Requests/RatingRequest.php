<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class RatingRequest extends Request
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
            'rate' => 'required|float_between:0.00,5.00',
            'user' => 'required|exists:users,id',
        ];
    }
}
