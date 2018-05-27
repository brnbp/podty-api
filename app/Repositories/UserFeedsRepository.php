<?php

namespace App\Repositories;

use App\Models\Feed;
use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class UserFeedsRepository
{
    public static function all($username)
    {
        return Cache::remember('user_feeds_'.$username, 60, function () use ($username) {
            return self::buildQuery(User::whereUsername($username))
                ->orderBy('last_episode_at', 'DESC')
                ->get();
        });
    }

    public static function one($username, $feedId)
    {
        return Cache::remember('user_feeds_'.$feedId.'_'.$username, 60, function () use ($username, $feedId) {
            return self::buildQuery(User::whereUsername($username)
                ->whereFeedId($feedId))
                ->get();
        });
    }

    public static function first(Feed $feed, User $user): UserFeed
    {
        return $user->feeds()->whereFeedId($feed->id)->firstOrFail();
    }

    public static function create($feedId, User $user)
    {
        $userFeed = UserFeed::firstOrCreate([
            'user_id' => $user->id,
            'feed_id' => $feedId,
        ]);

        if (!$userFeed) {
            return false;
        }

        Cache::forget('user_feeds_'.$feedId.'_'.$user->username);
        Cache::forget('feeds_listeners_'.$feedId);
        UserRepository::incrementsPodcastsCount($userFeed);
        FeedRepository::incrementsListeners($feedId);

        self::markAllNotListened($feedId);

        UserEpisodesRepository::createAllEpisodesFromUserFeed($userFeed);

        return $userFeed->fresh();
    }

    public static function delete(Feed $feed, User $user)
    {
        $userFeed = self::first($feed, $user);

        UserRepository::decrementsPodcastCount($userFeed);
        FeedRepository::decrementsListeners($feed->id);

        Cache::forget('feeds_listeners_'.$feed->id);
        Cache::forget('user_feeds_'.$user->username);
        Cache::forget('user_feeds_'.$feed->id.'_'.$user->username);

        return $userFeed->delete();
    }

    public static function markAllListened($id, $boolean = true)
    {
        return UserFeed::whereId($id)->update(['listen_all' => $boolean]);
    }

    public static function markAllNotListened($id)
    {
        self::markAllListened($id, false);
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
                    'feeds.main_color as color',
                    'feeds.description',
                    'feeds.total_episodes',
                    'feeds.last_episode_at',
                    'user_feeds.listen_all'
                );
    }
}
