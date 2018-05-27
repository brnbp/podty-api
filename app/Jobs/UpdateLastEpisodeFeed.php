<?php

namespace App\Jobs;

use App\Filter\Filter;
use App\Models\Episode;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLastEpisodeFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    public function __construct()
    {
        $this->queue = 'low';
    }

    /**
     * Atualiza a data do ultimo episodio lançado.
     *
     * @param \App\Filter\Filter                   $filter
     * @param \App\Repositories\FeedRepository     $feedRepository
     * @param \App\Repositories\EpisodesRepository $episodesRepository
     */
    public function handle(Filter $filter, FeedRepository $feedRepository, EpisodesRepository $episodesRepository)
    {
        $filter->setLimit(9999);

        $episodesRepository
            ->latests($filter)
            ->unique('feed_id')
            ->each(function (Episode $episode) use ($feedRepository) {
                $feedRepository->updateLastEpisodeDate($episode->feed_id, $episode->published_date);
            });
    }
}
