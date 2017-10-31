<?php
namespace App\Jobs;

use App\Models\Feed;
use App\Repositories\FeedRepository;
use App\Services\Itunes\Finder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SearchNewFeed implements ShouldQueue
{
    use SerializesModels, Queueable;

    /** @var string $feedName possible feed name */
    public $feedName;

    public function __construct(string $feedName)
    {
        $this->feedName = $feedName;
    }

    public function handle(FeedRepository $repository, Finder $finder)
    {
        $feeds = collect($finder->all($this->feedName));

        return $feeds->map(function ($feed) use ($repository) {
            return $repository->updateOrCreate($feed->toArray());
        });
    }
}
