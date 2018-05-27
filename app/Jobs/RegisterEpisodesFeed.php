<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\Feed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class RegisterEpisodesFeed
 * Coloca na fila todos os feeds existentes para busca de novos episodios.
 */
class RegisterEpisodesFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    /** @var int $id feed id */
    public $id;

    /** @var string $url feed url */
    public $url;

    /**
     * @var bool
     */
    public $force;

    /**
     * @param array $feed  array com $feed['id'] and $feed['url'] indices
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
     * Busca por novos episodios a partir de feed.
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
