<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use App\Services\Password;
use Illuminate\Database\QueryException;

class UserRepository
{
    public static function byId($id)
    {
        return User::whereId($id)->get();
    }

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
        return User::whereUsername($username)->firstOrFail();
    }

    public static function delete(User $user)
    {
        try {

            $user->feeds->map(function($feed){
                FeedRepository::decrementsListeners($feed->id);
            });

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
        return User::whereId($userFeed->user_id)->decrement('podcasts_count');
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
