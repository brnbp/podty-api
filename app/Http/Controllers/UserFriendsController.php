<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserFriendsRepository;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;
use Illuminate\Support\Facades\Cache;

class UserFriendsController extends ApiController
{
    public function all(User $user)
    {
        $data = Cache::remember('user_friends_' . $user->username, 60, function() use ($user) {
            return $user->friends->map(function($friendship){
                return (new UserTransformer)->transform($friendship->friend);
            })->sortByDesc('last_update')->toArray();
        });

        if (!$data) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess(array_values($data));
    }

    public function follow(User $user, User $friend)
    {
        Cache::forget('user_friends_' . $user->username);
        UserFriendsRepository::follow($user->id, $friend->id);
        UserRepository::incrementsFriendsCount($user->id);
    }

    public function unfollow(User $user, User $friend)
    {
        Cache::forget('user_friends_' . $user->username);
        UserFriendsRepository::unfollow($user->id, $friend->id);
        UserRepository::decrementsFriendsCount($user->id);
    }
}
