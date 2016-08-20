<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use App\Services\Password;
use Illuminate\Database\QueryException;

class UserRepository
{
    public static function create($userData)
    {
        $user = new User([
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => Password::encrypt($userData['password']),
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
        return User::whereUsername($username)->first();
    }

    public static function delete(User $user)
    {
        try {
            $deleted = $user->delete();
        } catch (QueryException $e) {
            return false;
        }

        return $deleted;
    }

    public static function getId($username)
    {
        $user = static::first($username);
        if (!$user) {
            return false;
        }
        return $user->id;
    }

    public static function incrementsPodcastsCount(UserFeed $userFeed)
    {
        if ($userFeed->wasRecentlyCreated) {
            return User::whereId($userFeed->user_id)->increment('podcasts_count');
        }
        return false;
    }

    public static function decrementsPodcastCount(UserFeed $userFeed)
    {
        if ($userFeed->wasRecentlyCreated) {
            return User::whereId($userFeed->user_id)->decrement('podcast_count');
        }
        return false;
    }
}
