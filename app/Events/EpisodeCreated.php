<?php
namespace App\Events;

use App\Models\Episode;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeCreated
{
    use SerializesModels, Dispatchable;

    /**
     * @var \App\Models\Episode
     */
    public $episode;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Episode $episode
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }
}
