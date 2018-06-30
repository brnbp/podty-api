<?php
namespace App\Transform;

class UserFavoritesTransformer extends TransformerAbstract
{
    private $feedTransformer;

    private $episodeTransformer;

    public function __construct(FeedTransformer $feedTransformer, EpisodeTransformer $episodeTransformer)
    {
        $this->feedTransformer = $feedTransformer;
        $this->episodeTransformer = $episodeTransformer;
    }

    public function transform($favorite)
    {
        return array_merge(
            $favorite,
            ['feed' => $this->feedTransformer->transform($favorite['feed'], true)],
            ['episode' => $this->episodeTransformer->transform($favorite['episode'])]
        );
    }
}
