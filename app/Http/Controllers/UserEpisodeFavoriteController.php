<?php
namespace App\Http\Controllers;

use App\Repositories\UserEpisodeFavoriteRepository;

class UserEpisodeFavoriteController extends ApiController
{
    public function favorite($username, $episode)
    {
        $userEpisodeFavorite = UserEpisodeFavoriteRepository::create($username, $episode);

        if (!$userEpisodeFavorite) {
            return $this->respondBadRequest();
        }

        return $this->respondCreated($userEpisodeFavorite);
    }

    public function unfavorite($username, $episode)
    {
        $userEpisodeFavorite = UserEpisodeFavoriteRepository::delete($username, $episode);

        if (!$userEpisodeFavorite) {
            return $this->respondBadRequest();
        }

        return $this->respondSuccess(['deleted' => true]);
    }
}
