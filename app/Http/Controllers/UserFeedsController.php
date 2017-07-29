<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserEpisodesRepository;
use App\Repositories\UserFeedsRepository;
use App\Repositories\UserRepository;
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
        if (UserFeedsRepository::delete($feedId->id, $username)) {
            $this->respondSuccess(['removed' => true]);
        }
    
        $this->respondBadRequest();
    }

    public function listenAll(User $username, $feedId)
    {
        $userFeed = UserFeedsRepository::first($feedId, $username->id);
        
        UserEpisodesRepository::deleteAll($userFeed);
        
        UserFeedsRepository::markAllListened($userFeed->id);

        return $this->respondSuccess();
    }
}
