<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Feed;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Itunes\Finder as ItunesFinder;

class FeedController extends Controller
{
    private $Feed;

    public function __construct()
    {
        $this->Feed = new Feed();
    }

    public function create($name)
    {
        $this->createFeeds($name);

        $feed = $this->Feed->getContent();

        // DISPATCH JOB TO SAVE ON 'EPISODES TABLE' ALL EPISODES OF FEED
        // MAKE IT ASYNC/BACKGROUND
        (new Episode())
            ->storage($feed['id'], $feed['url']);
    }

    /**
     * Salva o podcast pesquisado no banco
     * @param string $name nome do podcast
     */
    private function createFeeds($name)
    {
        $results = (new ItunesFinder($name))
            ->all();

        if ($results == false) {
            die(header('not faunded', '', 404));
        }

        $this->Feed->storage($results);
    }
}
