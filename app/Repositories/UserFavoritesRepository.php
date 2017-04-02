<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserFavorite;

class UserFavoritesRepository
{
    public static function first($userId, $episodeId)
    {
        return UserFavorite::whereUserId($userId)
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
        return $user->favorites()
                    ->with('Episode')
                    //->with('Feeds')
                    ->orderBy('id', 'desc')
                    ->get();
    }
}
