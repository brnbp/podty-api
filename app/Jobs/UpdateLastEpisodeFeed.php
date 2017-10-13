<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Episode;
use App\Models\Feed;
use App\Filter\Filter;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLastEpisodeFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Atualiza a data do ultimo episodio lan�ado
     *
     */
    public function handle(Filter $filter)
    {
        $filter->setLimit(900);

        $Episodes = (new EpisodesRepository)->latests($filter);
        $Episodes
            ->unique('feed_id')
            ->map(function($episode){
                (new FeedRepository(new Feed))
                    ->updateLastEpisodeDate($episode->feed_id, $episode->published_date);
            });
    }
}
