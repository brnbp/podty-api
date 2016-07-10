<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;

class UserFeedsRepository
{
    public static function all($username)
    {
        return User::whereUsername($username)
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->select('feeds.id', 'feeds.name', 'feeds.thumbnail_30')
            ->get();
    }

    public static function one($username, $feedId)
    {
        return User::whereUsername($username)
            ->whereFeedId($feedId)
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->select('feeds.id', 'feeds.name', 'feeds.thumbnail_30')
            ->get();
    }

    public static function first($feedId, $userId)
    {
        return UserFeed::whereFeedId($feedId)->whereUserId($userId)->first();
    }

    public static function create($feedId, User $user)
    {
       $userFeed = UserFeed::firstOrCreate([
            'user_id' => $user->id,
            'feed_id' => $feedId
        ]);

        return $userFeed;
    }

    public static function batchCreate($feedsId, User $user)
    {
        foreach ($feedsId as $feedId) {
            self::create($feedId, $user);
        }
    }

    public static function delete($feedId, User $user)
    {
        $userFeed = self::getFirst($feedId, $user->id);
        if (!$userFeed) {
            return false;
        }

        return $userFeed->delete();
    }
}
