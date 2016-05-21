<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Episode;
use App\Services\Filter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\RegisterEpisodesFeed;
use App\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->Filter = new Filter();

        if ($this->Filter->validateFilters() === false) {
            die(http_response_code(400));
        }
    }

    public function retrieve(int $feedId)
    {
        return
            (new Episode())->getByFeedId($feedId, $this->Filter) ?:
                (new Response())->setStatusCode(404);
    }
}
