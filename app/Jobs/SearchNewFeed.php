<?php
namespace App\Jobs;

use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class SearchNewFeed implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    /** @var string $feedName possible feed name */
    public $feedName;

    public function __construct(string $feedName)
    {
        $this->feedName = $feedName;
    }

    public function handle(Feed $feed)
    {
        $feed->persist($this->feedName);
    }
}
