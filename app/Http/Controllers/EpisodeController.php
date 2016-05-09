<?php
namespace App\Http\Controllers;

use App\Models\Feed;
use App\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\RegisterEpisodesFeed;
use App\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    public function retrieve($feed)
    {
        $Feed = new Feed();

        if (!$Feed->checkExists($feed)) {
            // criar feed?
            return (new Response())->setStatusCode(404);
        }

        $ret = (new Episode())
            ->getBy('feed_id', $Feed->getContent()['id']);

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
