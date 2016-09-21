<?php
namespace App\Http\Controllers;

use App\Repositories\UserFriendsRepository;
use App\Repositories\UserRepository;

class UserFriendsController extends Controller
{
    public function follow($username, $friendUsername)
    {
        $userId = UserRepository::getId($username);
        $friendUserId = UserRepository::getId($friendUsername);

        UserFriendsRepository::follow($userId, $friendUserId);
        UserRepository::incrementsFriendsCount($userId);
    }

    public function unfollow($username, $friendUsername)
    {
        $userId = UserRepository::getId($username);
        $friendUserId = UserRepository::getId($friendUsername);

        UserFriendsRepository::unfollow($userId, $friendUserId);
        UserRepository::decrementsFriendsCount($userId);
    }
}
