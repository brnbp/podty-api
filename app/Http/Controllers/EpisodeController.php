<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Episode;
use App\Filter\Filter;
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
        $episodes = (new Episode)->getByFeedId($feedId, $this->filter);

        if ($episodes) {
            return $this->respond($episodes);
        }

        return $this->respondNotFound();
    }

    public function latest()
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $episodes = (new Episode)->getLatests($this->filter);

        if ($episodes->count()) {
            return $this->respond($episodes);
        }

        return $this->respondNotFound();
    }
}
