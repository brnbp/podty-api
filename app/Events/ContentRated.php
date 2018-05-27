<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
