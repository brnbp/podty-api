<?php
namespace App\Services;

use App\Jobs\FindNewEpisodesForFeed;
use App\Jobs\UpdateLastEpisodeFeed;
use App\Models\Feed;
use App\Repositories\FeedRepository;

class Queue
{
    public function searchNewEpisodes()
    {
        $feeds = (new FeedRepository(new Feed))->all();

        $feeds->each(function (Feed $feed) {
            FindNewEpisodesForFeed::dispatch([
                'id' => $feed->id,
                'url' => $feed->url,
            ]);
        });
    }

    public function updateLastEpisodeAt()
    {
        UpdateLastEpisodeFeed::dispatch();
    }

    public function send()
    {
        $this->searchNewEpisodes();
        $this->updateLastEpisodeAt();
    }
}
