<?php
namespace App\Repositories;

use App\Models\UserFriend;

class UserFriendsRepository
{
    public static function follow($userId, $friendUserId)
    {
        UserFriend::create([
            'user_id' => $userId,
            'friend_user_id' => $friendUserId
        ]);
    }

    public static function unfollow($userId, $friendUserId)
    {
        UserFriend::whereUserId($userId)
            ->whereFriendUserId($friendUserId)
            ->delete();
    }
}
