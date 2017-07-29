<?php
namespace App\Repositories;

use App\Models\UserFriend;

class UserFriendsRepository
{
    public static function follow($userId, $friendUserId) : bool
    {
        $user = UserFriend::firstOrCreate([
            'user_id' => $userId,
            'friend_user_id' => $friendUserId
        ]);
        
        return $user->wasRecentlyCreated;
    }

    public static function unfollow($userId, $friendUserId) :bool
    {
        return UserFriend::whereUserId($userId)
            ->whereFriendUserId($friendUserId)
            ->delete();
    }
}
