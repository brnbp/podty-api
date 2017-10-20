<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ContentRated
{
    use SerializesModels;

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
