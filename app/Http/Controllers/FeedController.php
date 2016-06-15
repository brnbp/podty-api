<?php

namespace App\Http\Controllers;

use App\Jobs\SendLogToWarehouse;
use App\Models\Episode;
use App\Models\Feed;
use App\Services\Logger\Warehouse;
use App\Services\Queue;
use App\Transform\FeedTransformer;
use Illuminate\Http\Response;
use App\Jobs\RegisterEpisodesFeed;
use App\Http\Controllers\Controller;
use App\Services\Itunes\Finder as ItunesFinder;

class FeedController extends Controller
{
    /**
     * @var Feed
     */
    private $Feed;

    /**
     * @var FeedTransformer
     */
    private $feedTransformer;

    public function __construct(Feed $feed, FeedTransformer $feedTransformer)
    {
        $this->Feed = $feed;
        $this->feedTransformer = $feedTransformer;
    }

    public function retrieve($name)
    {
        $this->Feed->findLikeName($name);

        if ($this->Feed->has_content) {
            return $this->feedTransformer->transformCollection($this->Feed->getContent());
        }

        return $this->create($name);
    }

    /**
     * @param $id
     *
     */
    public function retrieveById($id)
    {
        $feed = Feed::where('id', $id)->get();

        if ($feed->count()) {
            return $this->feedTransformer->transformCollection($feed->toArray());
        }

        return  (new Response)->setStatusCode(404);
    }

    /**
     * Cria feed e adiciona em fila a importação de episodios
     * @param string $name nome do podcast a ser criado
     * @return Response
     */
    private function create($name)
    {
        if ($this->createFeeds($name) == false) {
            return (new Response)->setStatusCode(404);
        }

        $feed = $this->Feed->getContent();

        if (empty($feed)) {
            return (new Response)->setStatusCode(404);
        }

        (new Queue)->searchNewEpisodes([$feed]);

        return (new Response())->setStatusCode(202);
    }

    /**
     * Salva o podcast pesquisado no banco
     * @param string $name nome do podcast
     * @return bool
     */
    private function createFeeds($name)
    {
        $results = (new ItunesFinder($name))
            ->all();

        if ($results == false) {
            return false;
        }

        $this->Feed->storage($results);

        return true;
    }

    public function latest()
    {
        $latestsFeeds = (new Feed())->getLatestsUpdated()->toArray();

        if (empty($latestsFeeds)) {
            return (new Response)->setStatusCode(404);
        }
        return $this->feedTransformer->transformCollection($latestsFeeds);
    }
}
