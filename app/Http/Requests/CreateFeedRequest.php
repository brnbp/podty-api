<?php
namespace App\Http\Requests;

class CreateFeedRequest extends Request
{
    public function rules()
    {

        return [
            'name' => 'bail|required|string',
            'itunes_id' => 'bail|required|unique:feeds,itunes_id',
            'url' => 'bail|required',
            'thumbnail_30' => 'string',
            'thumbnail_60' => 'string',
            'thumbnail_100' => 'string',
            'thumbnail_600' => 'string',
        ];
    }
}
