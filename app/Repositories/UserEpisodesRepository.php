<?php
namespace App\Repositories;

use App\Models\UserEpisode;

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
        return UserEpisode::firstOrCreate($data);
    }

    public static function batchCreate($bulk)
    {
        foreach ($bulk as $data) {
            self::create($data);
        }
    }

    public static function delete($userFeedId, $episodeId)
    {
        $userEpisode= self::first($userFeedId, $episodeId);
        if (!$userEpisode) {
            return false;
        }

        return $userEpisode->delete();
    }
}
