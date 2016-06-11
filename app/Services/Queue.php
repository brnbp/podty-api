<?php

namespace App\Services;

use App\Models\Feed;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Queue
{
    use DispatchesJobs;

    public function searchNewEpisodes($feeds = null)
    {
        (new Feed)
            ->cronSearchForNewEpisodes($feeds);
    }

    public function updateLastEpisodeAt()
    {
        (new Feed)->cronUpdateLastEpisodeAt();
    }

    public function send()
    {
        $this->searchNewEpisodes();
        $this->updateLastEpisodeAt();
    }

}
