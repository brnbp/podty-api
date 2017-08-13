<?php
namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\User;
use App\Repositories\UserFavoritesRepository;

class UserFavoriteController extends ApiController
{
    public function all(User $user)
    {
        $favorites = UserFavoritesRepository::all($user);

        if (!$favorites->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess($favorites);
    }

    public function favorite(User $user, Episode $episode)
    {
        UserFavoritesRepository::create($user, $episode);

        return $this->respondCreated();
    }

    public function unfavorite(User $user, Episode $episode)
    {
        $userEpisodeFavorite = UserFavoritesRepository::delete($user, $episode);

        if ($userEpisodeFavorite) {
            return $this->respondSuccess(['deleted' => true]);
        }

        return $this->respondNotFound();
    }
}
