<?php
namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Feed;

class RatingController extends ApiController
{
    public function create(RatingRequest $request, Feed $feed)
    {
        $rate = $feed->ratings()->firstOrCreate([
           'user_id' => $request->user,
           'rate' => $request->rate,
        ]);
    
        return $rate->wasRecentlyCreated ?
                $this->respondCreated($rate) :
                $this->respondBusinessLogicError('User already rated this content');
    }
}
