<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserEpisodeFavorite;

class UserEpisodeFavoriteRepository
{
    public static function first($userId, $episodeId)
    {
        return UserEpisodeFavorite::whereUserId($userId)
                    ->whereEpisodeId($episodeId)
                    ->first() ?: false;
    }

    public static function create(User $user, $episodeId)
    {
        if (!EpisodesRepository::exists($episodeId)) {
            return false;
        }

        return $user->favorites()
                    ->firstOrCreate(['episode_id' => $episodeId]);
    }

    public static function delete(User $user, $episodeId)
    {
        if (!EpisodesRepository::exists($episodeId)) {
            return false;
        }

        return $user->favorites()->whereEpisodeId($episodeId)->delete() ? true : false;
    }

    public static function all(User $user)
    {
        return $user->favorites()->with('Episode')->orderBy('id', 'desc')->get();
    }
}
