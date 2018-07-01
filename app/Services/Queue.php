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
        $feedsRepository = app(FeedRepository::class);

        $feeds = $feedsRepository->model
            ->select('id', 'url')
            ->orderBy('listeners', 'DESC')
            ->get();

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
