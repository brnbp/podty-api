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
        $data = $user->friends()->get()->map(function($friend){
            $find = User::whereId($friend->friend_user_id)->first();
            if ($find) {
                return (new UserTransformer)->transform($find);
            }
            return [];
        });

        if (!$data || !$data->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess($data);
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
