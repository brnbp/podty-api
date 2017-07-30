<?php
namespace App\Http\Controllers;

use App\Filter\Filter;
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

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
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

        $episodes = (new EpisodesRepository)
                        ->retrieveByFeed($feed, $this->filter);
        
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
            $feed = (new FeedRepository)->first($episode->feed_id);
            $feed = (new FeedTransformer)->transform($feed);
            $feed['episodes'] = array((new EpisodeTransformer)->transform($episode));
            return $feed;
        });

        return $this->respondSuccess($response);
    }

    public function one($episodeId)
    {
        $episode = (new EpisodesRepository)->one($episodeId);

        if (!$episode) {
            return $this->respondNotFound();
        }

        $feed = (new FeedRepository)->first($episode->feed_id);

        $response = $this->transformOne($episode, $feed);

        return $this->respondSuccess($response);
    }

    private function transformOne($episode, $feed)
    {
        $feed = (new FeedTransformer)->transform($feed);

        $feed['episodes'] = (new EpisodeTransformer)
                                 ->transform($episode->toArray());

        return $feed;
    }

    private function transformAll($episodes, $feed)
    {
        $feed = (new FeedTransformer)->transform($feed);

        $feed['episodes'] = (new EpisodeTransformer)
                                ->transformCollection($episodes->toArray());
        return $feed;
    }
}
