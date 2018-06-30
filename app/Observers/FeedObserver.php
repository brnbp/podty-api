<?php
namespace App\Observer;

use App\Jobs\FindNewEpisodesForFeed;
use App\Jobs\UpdateFeedsMetadata;
use App\Models\Feed;

class FeedObserver
{
    public function created(Feed $feed)
    {
        $feed->slug = Feed::slugfy($feed->id, $feed->name);
        $feed->save();

        FindNewEpisodesForFeed::dispatch([
            'id' => $feed->id,
            'url' => $feed->url,
        ], true);
        UpdateFeedsMetadata::dispatch($feed);
    }
}
