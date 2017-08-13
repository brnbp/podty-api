<?php
namespace App\Http\Controllers;

use App\Filter\Filter;
use App\Models\Episode;
use App\Models\Feed;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;

class EpisodeController extends ApiController
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var \App\Transform\EpisodeTransformer
     */
    private $episodeTransformer;
    
    public function __construct(Filter $filter, EpisodeTransformer $episodeTransformer)
    {
        $this->filter = $filter;
        $this->episodeTransformer = $episodeTransformer;
    }
    
    /**
     * @param \App\Models\Feed $feed
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param int $feedId
     */
    public function retrieve(Feed $feed)
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $episodes = (new EpisodesRepository)->retrieveByFeed($feed, $this->filter);
        
        if (!$episodes) {
            return $this->respondNotFound();
        }

        $response = $this->transformAll($episodes, $feed);

        return $this->respondSuccess($response);
    }

    public function latest()
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $episodes = (new EpisodesRepository)->latests($this->filter);

        if ($episodes->isEmpty()) {
            return $this->respondNotFound();
        }

        $response = $episodes->map(function ($episode){
            $feed = $episode->feed();
            $feed = (new FeedTransformer)->transform($feed);
            $feed['episodes'] = [$this->episodeTransformer->transform($episode)];
            return $feed;
        });

        return $this->respondSuccess($response);
    }

    public function one(Episode $episode)
    {
        $feed = $episode->feed();

        $response = $this->transformOne($episode, $feed);

        return $this->respondSuccess($response);
    }

    private function transformOne($episode, $feed)
    {
        $feed = (new FeedTransformer)->transform($feed);

        $feed['episodes'] = $this->episodeTransformer->transform($episode->toArray());

        return $feed;
    }

    private function transformAll($episodes, $feed)
    {
        $feed = (new FeedTransformer)->transform($feed);

        $feed['episodes'] = $this->episodeTransformer->transformCollection($episodes->toArray());

        return $feed;
    }
}
