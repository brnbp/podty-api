<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;

class UserFeedsRepository
{
    public static function all($username)
    {
        return self::buildQuery(User::whereUsername($username))
                    ->orderBy('last_episode_at', 'DESC')
                    ->get();
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

    public static function usersByFeedId($feedId, $userId = 12)
    {
        return User::where('user_feeds.feed_id', $feedId)
                        ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
                        ->orderBy('user_feeds.id', 'desc')
                        ->get();
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
                    'feeds.thumbnail_100',
                    'feeds.thumbnail_600',
                    'feeds.total_episodes',
                    'feeds.last_episode_at',
                    'user_feeds.listen_all'
                );
    }
}
