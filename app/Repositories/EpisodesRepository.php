<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;

class EpisodesRepository
{
    public static function feedId($episodeId)
    {

        return Episode::whereId($episodeId)->first()->feed_id;
    }
}
