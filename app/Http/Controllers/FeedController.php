<?php

namespace App\Http\Controllers;

use App\Jobs\SendLogToWarehouse;
use App\Models\Episode;
use App\Models\Feed;
use App\Services\Logger\Warehouse;
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

    public function __construct()
    {
        $this->Feed = new Feed();
    }

    public function retrieve($name)
    {
        $this->Feed->findLikeName($name);

        return $this->Feed->has_content ?
            $this->Feed->getContent() :
            $this->create($name);
    }

    /**
     * Cria feed e adiciona em fila a importação de episodios
     * @param string $name nome do podcast a ser criado
     * @return Response
     */
    private function create($name)
    {
        if ($this->createFeeds($name) == false) {
            return (new Response())->setStatusCode(404);
        }

        $feed = $this->Feed->getContent();

        if (empty($feed)) {
            return (new Response())->setStatusCode(404);
        }

        $this->Feed->sendToQueueUpdate([$feed]);

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
        return (new Feed())->getLatestsUpdated();
    }
}
