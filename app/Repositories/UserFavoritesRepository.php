<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\Cache;

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
        $episode = EpisodesRepository::first($episodeId);

        Cache::forget('user_favorites_' . $user->username);

        return $user->favorites()
                    ->firstOrCreate([
                        'feed_id' => $episode->feed_id,
                        'episode_id' => $episodeId
                    ]);
    }

    public static function delete(User $user, $episodeId)
    {
        if (!EpisodesRepository::exists($episodeId)) {
            return false;
        }

        Cache::forget('user_favorites_' . $user->username);

        return $user->favorites()->whereEpisodeId($episodeId)->delete() ? true : false;
    }

    public static function all(User $user)
    {
        return Cache::remember('user_favorites_' . $user->username, 120, function() use ($user) {
            return $user->favorites()->orderBy('id', 'desc')->get();
        });
    }
}
