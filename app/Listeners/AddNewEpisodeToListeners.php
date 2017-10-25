<?php
namespace App\Listeners;

use App\Events\EpisodeCreated;
use App\Repositories\EpisodesRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNewEpisodeToListeners implements ShouldQueue
{
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
