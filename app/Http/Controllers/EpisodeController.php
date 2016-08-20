<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Episode;
use App\Filter\Filter;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\RegisterEpisodesFeed;
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

        $meta_data = [
            'total_episodes'  => (new FeedRepository)->totalEpisodes($feedId)['total_episodes'],
            'feed' => '/v1/feeds/id/' . $feedId
        ];

        return $this->respondSuccess($episodes->toArray(), $meta_data);
    }

    public function latest()
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $episodes = (new EpisodesRepository)->latests($this->filter);

        if ($episodes->count()) {
            return $this->respondSuccess($episodes);
        }

        return $this->respondNotFound();
    }
}
