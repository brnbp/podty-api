<?php
namespace App\Repositories;

use App\Filter\Filter;
use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserEpisodesRepository
{
    public static function retrieve(User $user, Feed $feed): Collection
    {
        $cacheHash = md5('user_' . $user->username . '_feeds_' . $feed->id . '_episodes');
        return Cache::remember($cacheHash, 5, function() use ($user, $feed) {
            $userFeed = $user->feeds()->whereFeedId($feed->id)->firstOrFail();
            return $userFeed->episodes->map(function($userEpisode){
                $episode = $userEpisode->episode;
                $episode->paused_at = $userEpisode->paused_at;
                return $episode;
            })->sortByDesc('published_date');
        });
    }

    public static function latests(string $username, Filter $filter)
    {
        $limit = $filter->limit;
        $offset = $filter->offset;

        return Cache::remember('user_episodes_latests_' . $username, 5, function() use ($username, $limit, $offset) {
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

    public static function delete(UserFeed $userFeed, Episode $episode) : bool
    {
        $userEpisode = self::first($userFeed->id, $episode->id);
       
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

    public static function deleteAll(UserFeed $userFeed)
    {
        return $userFeed->episodes()->delete();
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
        
        $episodes = (new EpisodesRepository)->retrieveByFeed($userFeed->feed, $filter);

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
    
    public function listening($username)
    {
        return User::whereUsername($username)
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'feeds.id', '=', 'user_feeds.feed_id')
            ->join('user_episodes', 'user_feeds.id','=', 'user_episodes.user_feed_id')
            ->join('episodes', 'episodes.id', '=', 'user_episodes.episode_id')
            ->where('user_episodes.paused_at', '>', 0)
            ->get();
    }
}
