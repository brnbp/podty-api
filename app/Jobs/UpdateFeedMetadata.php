<?php
namespace App\Jobs;

use App\Models\Feed;
use App\Services\Parser\XML;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateFeedMetadata implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * @var \App\Models\Feed $feed
     */
    public $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function handle(XML $xml)
    {
        $content = $xml->retrieve($this->feed->url);

        $description = (string) $content->channel->description;

        if ($description) {
            $this->feed->description = (string) $content->channel->description;
            $this->feed->save();
        }
    }
}
