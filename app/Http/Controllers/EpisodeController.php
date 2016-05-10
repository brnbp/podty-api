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

    public function retrieve(string $feed)
    {
        $Feed = new Feed();

        if (!$Feed->checkExists($feed)) {
            // criar feed?
            return (new Response())->setStatusCode(404);
        }

        $ret = (new Episode())
            ->getBy('feed_id', $Feed->getContent()['id'], [
                'limit' => $this->Filter->query_filters['limit'],
                'offset' => $this->Filter->query_filters['offset']
            ]);

        return $ret;
    }

    /**
     * Utilizado em Cron
     * Busca por episodios de podcast, a partir de feeds salvos no banco
     */
    public function update()
    {
        $episodes = Feed::all(['url', 'id'])->toArray();

        foreach ($episodes as $episode) {
            $this->dispatch(new RegisterEpisodesFeed($episode));
        }
    }
}
