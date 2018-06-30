<?php
namespace App\Jobs;

use App\Models\Episode;
use App\Models\Feed;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class FindNewEpisodesForFeed
 * Coloca na fila todos os feeds existentes para busca de novos episodios
 *
 * @package App\Jobs
 */
class FindNewEpisodesForFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    /** @var integer $id feed id */
    public $id;

    /** @var string $url feed url */
    public $url;

    /**
     * @var bool $force
     */
    public $force;

    /**
     * @param array $feed array com $feed['id'] and $feed['url'] indices
     * @param bool  $force
     */
    public function __construct(array $feed, bool $force = false)
    {
        $this->id = $feed['id'];
        $this->url = $feed['url'];
        $this->force = $force;
        $this->queue = 'low';
    }

    /**
     * Busca por novos episodios a partir de feed
     *
     * @param Episode          $episode
     * @param \App\Models\Feed $feed
     */
    public function handle(Episode $episode, Feed $feed)
    {
        if ($feed->wasRecentlyModifiedXML($this->url) || $this->force) {
            $episode->storage($this->id, $this->url);
        }
    }
}
