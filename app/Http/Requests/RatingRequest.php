<?php
namespace App\Http\Requests;

class RatingRequest extends Request
{
    public function rules()
    {
        return [
            'rate' => 'required|float_between:0.00,5.00',
        ];
    }
}
