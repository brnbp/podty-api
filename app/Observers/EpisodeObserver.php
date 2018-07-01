<?php
namespace App\Observer;

use App\Events\EpisodeCreated;
use App\Jobs\AddNewEpisodeToListeners;
use App\Models\Episode;

class EpisodeObserver
{
    public function created(Episode $episode)
    {
        EpisodeCreated::dispatch($episode);

        AddNewEpisodeToListeners::dispatch($episode);
    }
}
