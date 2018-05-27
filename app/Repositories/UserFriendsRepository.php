<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFriend;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserFriendsRepository
{
    public static function follow($userId, $friendUserId): bool
    {
        $user = UserFriend::firstOrCreate([
            'user_id'        => $userId,
            'friend_user_id' => $friendUserId,
        ]);

        return $user->wasRecentlyCreated;
    }

    public static function unfollow($userId, $friendUserId): bool
    {
        return UserFriend::whereUserId($userId)
            ->whereFriendUserId($friendUserId)
            ->delete();
    }

    public static function newestFollowers(User $user, int $intervalDays = 7): Collection
    {
        return UserFriend::whereFriendUserId($user->id)
                ->where('created_at', '>=', (string) Carbon::create()->subDays($intervalDays))
                ->get();
    }
}
