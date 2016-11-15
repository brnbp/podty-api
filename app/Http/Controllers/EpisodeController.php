<?php
namespace App\Http\Controllers;

use App\Filter\Filter;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param integer $feedId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function retrieve($feedId)
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $episodes = (new EpisodesRepository)->retriveByFeedId($feedId, $this->filter);

        if (!$episodes) {
            return $this->respondNotFound();
        }

        $feed = (new FeedRepository)->first($feedId);

        $response = $this->transform($episodes, $feed);

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

    private function transform($episodes, $feed)
    {
        $feed = (new FeedTransformer)->transform($feed);

        $feed['episodes'] = (new EpisodeTransformer)
                                ->transformCollection($episodes->toArray());
        return $feed;
    }
}
