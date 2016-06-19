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

class FeedController extends ApiController
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
            return $this->respondSuccess(
                $this->feedTransformer->transformCollection($this->Feed->getContent())
            );
        }

        return $this->create($name);
    }
    
    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveById($id)
    {
        $feed = Feed::where('id', $id)->get();

        if ($feed->count()) {
            return $this->respondSuccess($this->feedTransformer->transformCollection($feed->toArray()));
        }

        return $this->respondNotFound();
    }

    /**
     * Cria feed e adiciona em fila a importação de episodios
     * @param string $name nome do podcast a ser criado
     * @return Response
     */
    private function create($name)
    {
        if ($this->createFeeds($name) == false) {
            return $this->respondNotFound();
        }

        $feed = $this->Feed->getContent();

        if (empty($feed)) {
            return $this->respondNotFound();
        }

        (new Queue)->searchNewEpisodes([$feed]);

        return $this->respondAcceptedRequest();
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
            return $this->respondNotFound();
        }


        return $this->respondSuccess($this->feedTransformer->transformCollection($latestsFeeds));
    }
}
