<?php
namespace App\Repositories;

use App\Filter\Filter;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Illuminate\Support\Facades\Cache;

class UserEpisodesRepository
{
    public static function retrieve(string $username, $feedId)
    {
        return User::whereUsername($username)
            ->join('user_feeds', function($join) use ($feedId) {
                $join->on('users.id', '=', 'user_feeds.user_id')
                    ->where('user_feeds.feed_id', '=', $feedId);
            })
            ->join('user_episodes', 'user_feeds.id','=', 'user_episodes.user_feed_id')
            ->join('episodes', 'episodes.id', '=', 'user_episodes.episode_id')
            ->select(
                'episodes.id as id',
                'episodes.title as title',
                'episodes.media_url as media_url',
                'episodes.media_type as media_type',
                'episodes.published_date as published_date',
                'episodes.content as content',
                'user_episodes.paused_at'
            )
            ->orderBy('episodes.published_date', 'desc')
            ->get();
    }

    public static function latests(string $username, Filter $filter)
    {
        $limit = $filter->limit;
        $offset = $filter->offset;
        
        return Cache::remember('user_episodes_latests_' . $username, 10, function() use ($username, $limit, $offset) {
            return User::whereUsername($username)
                ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
                ->join('feeds', 'feeds.id', '=', 'user_feeds.feed_id')
                ->join('user_episodes', 'user_feeds.id','=', 'user_episodes.user_feed_id')
                ->join('episodes', 'episodes.id', '=', 'user_episodes.episode_id')
                ->orderBy('episodes.published_date', 'desc')
                ->take($limit)
                ->skip($offset)
                ->get();
        });
    }

    public static function first($userFeedId, $episodeId)
    {
        return UserEpisode::whereUserFeedId($userFeedId)
            ->whereEpisodeId($episodeId)
            ->firstOrFail();
    }

    public static function create($data)
    {
        return UserEpisode::updateOrCreate([
            'user_feed_id' => $data['user_feed_id'],
            'episode_id' => $data['episode_id']
        ],$data);
    }

    public static function batchCreate($bulk)
    {
        foreach ($bulk as $data) {
            self::create($data);
        }
    }

    public static function delete($userFeedId, $episodeId)
    {
        $userEpisode = self::first($userFeedId, $episodeId);
        if (!$userEpisode) {
            return false;
        }

        return $userEpisode->delete();
    }

    public static function count($userFeedId)
    {
        return UserEpisode::whereUserFeedId($userFeedId)->count();
    }

    public static function hasEpisodes($userFeedId)
    {
        return (self::count($userFeedId) > 0) ? true : false;
    }

    public static function deleteAll($userFeedId)
    {
        return UserEpisode::whereUserFeedId($userFeedId)->delete();
    }

    public static function markAsPaused($userFeedId, $episodeId, $time)
    {
        return UserEpisode::whereUserFeedId($userFeedId)
                ->whereEpisodeId($episodeId)
                ->update(['paused_at' => $time]);
    }

    public static function createAllEpisodesFromUserFeed(UserFeed $userFeed)
    {
        $filter = new Filter;
        $filter->limit = 9999;

        $episodes = (new EpisodesRepository)->retriveByFeedId($userFeed->feed_id, $filter);

        if (!$episodes) {
            return false;
        }

        $episodes = $episodes->map(function($item) use ($userFeed) {
            return [
                'user_feed_id' => $userFeed->id,
                'episode_id' => $item->id,
                'paused_at' => 0,
            ];
        });

        self::batchCreate($episodes->toArray());
    }
}
