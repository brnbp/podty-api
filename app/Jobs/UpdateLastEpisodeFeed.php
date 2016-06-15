<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Episode;
use App\Models\Feed;
use App\Filter\Filter;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLastEpisodeFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Atualiza a data do ultimo episodio lançado
     *
     */
    public function handle(Filter $filter)
    {
        $filter->setLimit(10);

        $Episodes = ((new Episode)->getLatests($filter));
        $Episodes
            ->unique('feed_id')
            ->map(function($episode){
                Feed::where('id', $episode->feed_id)
                    ->update([
                        'last_episode_at' => $episode->published_date
                    ]);
            });
    }
}
