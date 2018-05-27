<?php

namespace App\Listeners;

use App\Events\ContentRated;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateRating implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ContentRated $event
     *
     * @return void
     */
    public function handle(ContentRated $event)
    {
        $event->content->updateAverageRating();
    }
}
