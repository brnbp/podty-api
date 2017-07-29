<?php
namespace App\Http\Controllers;

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

    public function attach($username, $feedId)
    {
        $user = UserRepository::first($username);

        $userFeed = UserFeedsRepository::create($feedId, $user);

        if (!$userFeed) {
            return $this->setStatusCode(Response::HTTP_BAD_GATEWAY)->respondError('');
        }

        return $this->respondSuccess(['created' => true]);
    }

    public function detach($username, $feedId)
    {
        $user = UserRepository::first($username);
       
        $deleted = UserFeedsRepository::delete($feedId, $user);

        // TODO apagar tudo de UserEpisodes

        return $deleted ?
            $this->respondSuccess(['removed' => true]) :
            $this->respondNotFound();
    }

    public function listenAll($username, $feedId)
    {
        $userId = UserRepository::getId($username);
        
        $userFeed = UserFeedsRepository::first($feedId, $userId);

        UserEpisodesRepository::deleteAll($userFeed->id);
        UserFeedsRepository::markAllListened($userFeed->id);

        return $this->respondSuccess(['mark all as listened' => true]);
    }
}
