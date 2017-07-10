<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class UserFeedsRepository
{
    public static function all($username)
    {
        return Cache::remember('user_feeds_' . $username, 60, function() use ($username) {
            return self::buildQuery(User::whereUsername($username))
                ->orderBy('last_episode_at', 'DESC')
                ->get();
            });
    }

    public static function one($username, $feedId)
    {
        return Cache::remember('user_feeds_' . $feedId . '_' . $username, 60, function() use ($username, $feedId) {
            return self::buildQuery(User::whereUsername($username)
                ->whereFeedId($feedId))
                ->get();
        });
    }

    public static function first($feedId, $userId)
    {
        return UserFeed::whereFeedId($feedId)->whereUserId($userId)->first();
    }

    public static function idByEpisodeAndUsername($episodeId, $username)
    {
        $userId = UserRepository::getId($username);
        if (!$userId) {
            return false;
        }

        return self::idByEpisodeAndUser($episodeId, $userId);
    }

    public static function idByEpisodeAndUser($episodeId, $userId)
    {
        $feedId = EpisodesRepository::feedId($episodeId);
        if (!$feedId) {
            return false;
        }

        $userFeed = UserFeedsRepository::first($feedId, $userId);

        return $userFeed ? $userFeed->id : false;
    }

    public static function create($feedId, User $user)
    {
       $userFeed = UserFeed::firstOrCreate([
            'user_id' => $user->id,
            'feed_id' => $feedId
        ]);
    
        Cache::forget('user_feeds_' . $feedId . '_' . $user->username);
        Cache::forget('feeds_listeners_' . $feedId);
        UserRepository::incrementsPodcastsCount($userFeed);
        FeedRepository::incrementsListeners($feedId);

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
        FeedRepository::decrementsListeners($feedId);
        Cache::forget('feeds_listeners_' . $feedId);
        Cache::forget('user_feeds_' . $user->username);
        Cache::forget('user_feeds_' . $feedId . '_' . $user->username);
        return $userFeed->delete();
    }

    public static function markAllListened($id, $boolean = true)
    {
        return UserFeed::whereId($id)->update(['listen_all' => $boolean]);
    }

    public static function markAllNotListened($id)
    {
        return UserFeed::whereId($id)->update(['listen_all' => false]);
    }

    private static function buildQuery(Builder $builder)
    {
        return $builder->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
                ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
                ->select(
                    'feeds.id',
                    'feeds.name',
                    'feeds.slug',
                    'feeds.thumbnail_30',
                    'feeds.thumbnail_60',
                    'feeds.thumbnail_100',
                    'feeds.thumbnail_600',
                    'feeds.total_episodes',
                    'feeds.last_episode_at',
                    'user_feeds.listen_all'
                );
    }
}
