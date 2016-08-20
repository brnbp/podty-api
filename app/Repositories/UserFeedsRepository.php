<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;

class UserFeedsRepository
{
    public static function all($username)
    {
        return self::buildQuery(User::whereUsername($username))->get();
    }

    public static function one($username, $feedId)
    {
        return self::buildQuery(User::whereUsername($username)
                    ->whereFeedId($feedId))
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
        
        UserRepository::incrementsPodcastsCount($userFeed);

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
        $userFeed = self::first($feedId, $user->id);
        if (!$userFeed) {
            return false;
        }

        UserRepository::decrementsPodcastCount($userFeed);

        return $userFeed->delete();
    }

    private static function buildQuery(Builder $builder)
    {
        return $builder->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
                ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
                ->select('feeds.id', 'feeds.name', 'feeds.thumbnail_30');
    }
}
