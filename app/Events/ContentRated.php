<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ContentRated
{
    use SerializesModels, Dispatchable;

    public $content;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Episode|\App\Models\Feed $content
     *
     * @internal param $contentId
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
}
