<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class RegisterEpisodesFeed
 * Coloca na fila todos os feeds existentes para busca de novos episodios
 * @package App\Jobs
 */
class RegisterEpisodesFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var integer $id feed id */
    public $id;

    /** @var string $url feed url */
    public $url;

    /**
     * @param array $feed array com $feed['id'] and $feed['url'] indices
     */
    public function __construct(array $feed)
    {
        $this->id = $feed['id'];
        $this->url = $feed['url'];
    }

    /**
     * Busca por novos episodios a partir de feed
     * @param Episode $episode
     */
    public function handle(Episode $episode)
    {
        $episode->storage($this->id, $this->url);
    }
}
