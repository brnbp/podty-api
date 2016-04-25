<?php
namespace App\Http\Controllers;

use App\Feed;
use App\Episode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EpisodeController extends Controller
{
    public function retrieve($feed)
    {
        $Feed = new Feed();

        if (!$Feed->checkExists($feed)) {
            die(header('not faunded', '', 404));
        }

        $ret = (new Episode())
            ->getBy('feed_id', $Feed->getContent()['id']);


        printrx($ret);

    }

    /**
     *
     * Usar para job async
     * Salva episodios de podcast no banco, se nao existe ainda
     * @param Request $request
     */
    public function save(Request $request)
    {
        $feed_id = $request->get('id');
        $feed_url = (new Feed())->getUrlById($feed_id);

        (new Episode())
            ->storage($feed_id, $feed_url);
    }
}
