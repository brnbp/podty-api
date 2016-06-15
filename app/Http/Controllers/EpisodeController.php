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

class EpisodeController extends Controller
{
    /**
     * @var Filter
     */
    private $filter;

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
        if ($this->filter->validateFilters() === false) {
            return (new Response)->setStatusCode(400);
        }
    }


    /**
     * @param integer $feedId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function retrieve($feedId)
    {
        return
            (new Episode)->getByFeedId($feedId, $this->filter) ?:
                (new Response)->setStatusCode(404);
    }

    public function latest()
    {
        return (new Episode)->getLatests($this->filter);
    }
}
