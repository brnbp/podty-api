<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class AnalyticsPageView extends Event
{
    use SerializesModels;
    
    public $path;
    public $title;
    
    /**
     * Create a new event instance.
     *
     * @param $path
     * @param $title
     */
    public function __construct($path, $title)
    {
        $this->path = $path;
        $this->title = $title;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
