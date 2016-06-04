<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Episode;
use App\Services\Filter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\RegisterEpisodesFeed;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EpisodeController extends Controller
{
    /**
     * @param Filter  $filter
     * @param integer $feedId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function retrieve(Filter $filter, $feedId)
    {
        if ($filter->validateFilters() === false) {
            die(http_response_code(400));
        }

        return
            (new Episode())->getByFeedId($feedId, $filter) ?:
                (new Response())->setStatusCode(404);
    }

    public function latest()
    {
        return (new Episode())->getLatests();
    }
}
