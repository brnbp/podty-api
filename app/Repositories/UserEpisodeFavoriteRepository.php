<?php
namespace App\Repositories;

use App\Models\UserEpisodeFavorite;

class UserEpisodeFavoriteRepository
{
    public static function first($userId, $episodeId)
    {
        return UserEpisodeFavorite::whereUserId($userId)
                    ->whereEpisodeId($episodeId)
                    ->first() ?: false;
    }

    public static function create($username, $episodeId)
    {
        $userId = UserRepository::getId($username);

        if (!$userId) {
            return false;
        }

        if (!EpisodesRepository::exists($episodeId)) {
            return false;
        }

        try {
            return UserEpisodeFavorite::create([
                'user_id' => $userId,
                'episode_id' => $episodeId,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function delete($username, $episodeId)
    {
        $userId = UserRepository::getId($username);

        if (!$userId) {
            return false;
        }

        if (!EpisodesRepository::exists($episodeId)) {
            return false;
        }

        $userEpisodeFavorited = self::first($userId, $episodeId);

        if (!$userEpisodeFavorited) {
            return false;
        }

        return $userEpisodeFavorited->delete();
    }
}
