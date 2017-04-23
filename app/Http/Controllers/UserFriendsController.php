<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserFriendsRepository;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;

class UserFriendsController extends ApiController
{
    public function all(User $user)
    {
        $data = $user->friends->map(function($friendship){
            return (new UserTransformer)->transform($friendship->friend);
        })->sortByDesc('last_update')->toArray();

        if (!$data) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess(array_values($data));
    }

    public function follow(User $user, User $friend)
    {
        UserFriendsRepository::follow($user->id, $friend->id);
        UserRepository::incrementsFriendsCount($user->id);
    }

    public function unfollow(User $user, User $friend)
    {
        UserFriendsRepository::unfollow($user->id, $friend->id);
        UserRepository::decrementsFriendsCount($user->id);
    }
}
