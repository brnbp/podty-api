<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Episode;
use App\Models\User;
use App\Repositories\UserFavoritesRepository;

class UserFavoriteController extends ApiController
{
    /**
     * @var \App\Repositories\UserFavoritesRepository $repository
     */
    private $repository;

    public function __construct(UserFavoritesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(User $user)
    {
        $favorites = $this->repository->all($user);

        if (!$favorites->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess($favorites);
    }

    public function favorite(User $user, Episode $episode)
    {
        $this->repository->create($user, $episode);

        return $this->respondCreated();
    }

    public function unfavorite(User $user, Episode $episode)
    {
        $userEpisodeFavorite = $this->repository->delete($user, $episode);

        if ($userEpisodeFavorite) {
            return $this->respondSuccess(['deleted' => true]);
        }

        return $this->respondNotFound();
    }
}
