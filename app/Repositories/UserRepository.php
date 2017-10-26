<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use App\Services\Password;

class UserRepository
{
    public static function create($userData)
    {
        $user = new User([
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => Password::encrypt($userData['password']),
            'friends_count' => 0,
            'podcasts_count' => 0,
        ]);

        $user->save();

        return $user;
    }

    public static function verifyAuthentication($userData)
    {
        $user = User::whereUsername($userData['username'])
                    ->wherePassword($userData['password'])
                    ->get();

        return $user->count();
    }

    public static function first($username)
    {
        return User::whereUsername($username)->firstOrFail();
    }

    public static function delete(User $user)
    {
        try {
            $user->feeds->map(function ($feed) {
                FeedRepository::decrementsListeners($feed->id);
            });

            $deleted = $user->delete();
        } catch (\Exception $e) {
            return false;
        }

        return $deleted;
    }

    public static function incrementsPodcastsCount(UserFeed $userFeed)
    {
        if ($userFeed->wasRecentlyCreated) {
            return $userFeed->user->increment('podcasts_count');
        }
    }

    public static function decrementsPodcastCount(UserFeed $userFeed)
    {
        return $userFeed->user->decrement('podcasts_count');
    }

    public static function incrementsFriendsCount($userId)
    {
        return User::whereId($userId)->increment('friends_count');
    }

    public static function decrementsFriendsCount($userId)
    {
        return User::whereId($userId)->decrement('friends_count');
    }
}
