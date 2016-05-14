<?php

namespace App\Http\Controllers;

use App\Jobs\SendLogToWarehouse;
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

    /**
     * Cria feed e adiciona em fila a importação de episodios
     * @param string $name nome do podcast a ser criado
     * @return Illuminate\Http\Response
     */
    public function create(string $name)
    {
        if ($this->createFeeds($name) == false) {
            (new Warehouse())->setWarning($name, 'not_found', ['error' => true]);
            return (new Response())->setStatusCode(404);
        }

        $feed = $this->Feed->getContent();

        if ($feed == false) {
            return (new Response())->setStatusCode(404);
        }

        $this->dispatch(new RegisterEpisodesFeed($feed));

        return (new Response())->setStatusCode(202);
    }

    /**
     * Salva o podcast pesquisado no banco
     * @param string $name nome do podcast
     * @return bool
     */
    private function createFeeds(string $name)
    {
        $results = (new ItunesFinder($name))
            ->all();

        if ($results == false) {
            return false;
        }

        $this->Feed->storage($results);

        return true;
    }

    public function retrieve(string $name)
    {
        $this->Feed->findLikeName($name);

        return $this->Feed->getContent();
    }
}
