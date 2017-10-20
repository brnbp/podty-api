<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Events\ContentRated;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\Request;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserEpisodesRepository;
use App\Repositories\UserFeedsRepository;
use Illuminate\Http\Response;

class UserFeedsController extends ApiController
{
    public function all($username)
    {
        $feeds = UserFeedsRepository::all($username);

        if ($feeds->count()) {
            return $this->respondSuccess($feeds);
        }

        return $this->respondNotFound();
    }

    public function one($username, $feedId)
    {
        $feed = UserFeedsRepository::one($username, $feedId);

        if ($feed->count()) {
            return $this->respondSuccess($feed);
        }

        return $this->respondNotFound();
    }

    public function attach(User $username, Feed $feedId)
    {
        $userFeed = UserFeedsRepository::create($feedId->id, $username);

        if (!$userFeed) {
            return $this->setStatusCode(Response::HTTP_BAD_GATEWAY)->respondError('');
        }

        return $this->respondSuccess($userFeed);
    }

    public function detach(User $username, Feed $feedId)
    {
        if (UserFeedsRepository::delete($feedId, $username)) {
            $this->respondSuccess(['removed' => true]);
        }

        $this->respondBadRequest();
    }

    public function listenAll(User $user, Feed $feed)
    {
        $userFeed = UserFeedsRepository::first($feed, $user);

        UserEpisodesRepository::deleteAll($userFeed);

        UserFeedsRepository::markAllListened($userFeed->id);

        return $this->respondSuccess();
    }

    public function rate(RatingRequest $request, User $user, Feed $feed)
    {
        $rate = $feed->ratings()->updateOrCreate(
            ['user_id' => $user->id,],
            ['rate' => $request->rate]
        );

        event(new ContentRated($feed));

        return $rate->wasRecentlyCreated ?
            $this->respondCreated($rate) :
            $this->respondSuccess($rate);
    }
}
