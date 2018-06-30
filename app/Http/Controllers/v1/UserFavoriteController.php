<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Episode;
use App\Models\User;
use App\Repositories\UserFavoritesRepository;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;

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

        $feedTransformer = app(FeedTransformer::class);
        $episodeTransformer = app(EpisodeTransformer::class);
        $favoritesResponse = $favorites->map(function($favorite) use($feedTransformer, $episodeTransformer){
            return
                array_merge(
                    $favorite->attributesToArray(),
                    ['feed' => $feedTransformer->transform($favorite->feed, true)],
                    ['episode' => $episodeTransformer->transform($favorite->episode)]
                );
            ;
        });


        return $this->respondSuccess($favoritesResponse);
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
