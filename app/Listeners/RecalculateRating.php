<?php
namespace App\Listeners;

use App\Events\ContentRated;
use App\Models\Rating;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateRating implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  FeedRated  $event
     * @return void
     */
    public function handle(ContentRated $event)
    {
        $event->content->updateAverageRating();
    }
}
