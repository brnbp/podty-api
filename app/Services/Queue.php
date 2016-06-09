<?php

namespace App\Services;

use App\Models\Feed;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Queue
{
    use DispatchesJobs;

    public function send()
    {
        (new Feed)
            ->cronSearchForNewEpisodes()
            ->cronUpdateLastEpisodeAt();
    }

}
