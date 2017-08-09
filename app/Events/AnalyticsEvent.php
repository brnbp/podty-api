<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class AnalyticsEvent extends Event
{
    use SerializesModels;
    
    public $category;
    public $action;
    
    /**
     * Create a new event instance.
     *
     * @param $category
     * @param $action
     */
    public function __construct($category, $action)
    {
        $this->category = $category;
        $this->action = $action;
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
