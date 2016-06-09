<?php

namespace App\Services;


use App\Models\Feed;

class Queue
{

    public function send()
    {
        (new Feed)->searchForNewEpisodes();
    }
    
}
