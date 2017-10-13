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
     * @param $content
     * @param $contentType
     *
     * @internal param $contentId
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
}
