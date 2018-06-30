<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Episode;
use App\Models\User;
use App\Repositories\UserFavoritesRepository;
use App\Transform\UserFavoritesTransformer;

class UserFavoriteController extends ApiController
{
    private $repository;

    private $favoritesTransformer;

    public function __construct(UserFavoritesRepository $repository, UserFavoritesTransformer $favoritesTransformer)
    {
        $this->repository = $repository;
        $this->favoritesTransformer = $favoritesTransformer;
    }

    public function all(User $user)
    {
        $favorites = $this->repository->all($user);

        if (!$favorites->count()) {
            return $this->respondNotFound();
        }

        $transformedFavorites = $this->favoritesTransformer->transformCollection($favorites->toArray());

        return $this->respondSuccess($transformedFavorites);
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
