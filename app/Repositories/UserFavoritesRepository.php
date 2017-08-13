<?php
namespace App\Repositories;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserFavoritesRepository
{
    public static function create(User $user, Episode $episode)
    {
        Cache::forget('user_favorites_' . $user->username);

        return $user->favorites()
                    ->firstOrCreate([
                        'feed_id' => $episode->feed_id,
                        'episode_id' => $episode->id
                    ]);
    }

    public static function delete(User $user, Episode $episode)
    {
        Cache::forget('user_favorites_' . $user->username);

        return $user->favorites()->whereEpisodeId($episode->id)->delete() ? true : false;
    }

    public static function all(User $user)
    {
        return Cache::remember('user_favorites_' . $user->username, 360, function() use ($user) {
            return $user->favorites()->orderBy('id', 'desc')->get();
        });
    }
}
