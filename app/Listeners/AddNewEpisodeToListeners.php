<?php
namespace App\Listeners;

use App\Events\EpisodeCreated;
use App\Repositories\EpisodesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNewEpisodeToListeners implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->queue = 'high';
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\EpisodeCreated $event
     *
     * @return void
     */
    public function handle(EpisodeCreated $event)
    {
        (new EpisodesRepository)->addToListeners($event->episode);
    }
}
