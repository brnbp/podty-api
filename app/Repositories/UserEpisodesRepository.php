<?php
namespace App\Repositories;

use App\Filter\Filter;
use App\Models\UserEpisode;
use App\Models\UserFeed;

class UserEpisodesRepository
{
    public static function all()
    {
    }

    public static function one()
    {
    }

    public static function first($userFeedId, $episodeId)
    {
        return UserEpisode::whereUserFeedId($userFeedId)
            ->whereEpisodeId($episodeId)
            ->first();
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
        $episodes = (new EpisodesRepository)->retriveByFeedId($userFeed->feed_id, new Filter);

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
