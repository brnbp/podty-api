<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserFavoritesRepository;

class UserFavoriteController extends ApiController
{
    public function all(User $username)
    {
        $favorites = UserFavoritesRepository::all($username);

        if (!$favorites->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess($favorites);
    }

    public function favorite(User $username, $episode)
    {
        $userEpisodeFavorite = UserFavoritesRepository::create($username, $episode);

        if (!$userEpisodeFavorite) {
            return $this->respondNotFound();
        }

        return $this->respondCreated();
    }

    public function unfavorite(User $username, $episode)
    {
        $userEpisodeFavorite = UserFavoritesRepository::delete($username, $episode);

        if ($userEpisodeFavorite) {
            return $this->respondSuccess(['deleted' => true]);
        }

        return $this->respondNotFound();
    }
}
