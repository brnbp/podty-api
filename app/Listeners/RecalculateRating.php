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
        $ratings = Rating::where('content_id', $event->content->id)
                ->where('content_type', $event->contentType)
                ->get();
        
        
        $average = $ratings->avg('rate');
        
        $event->content->avg_rating = $this->roundToHalfDecimalOrDecimal($average);
        
        $event->content->save();
    }
    
    /*
     * rounds number to 0.50, 1.00, 1.50, 2.00, 2.50 and so on
     */
    private function roundToHalfDecimalOrDecimal($number)
    {
        return round($number * 2) / 2;
    }
}
