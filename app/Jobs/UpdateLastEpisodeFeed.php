<?php
namespace App\Jobs;

use App\Filter\Filter;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateLastEpisodeFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    /**
     * Atualiza a data do ultimo episodio lançado
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
            ->each(function ($episode) use ($feedRepository) {
                $feedRepository->updateLastEpisodeDate($episode->feed_id, $episode->published_date);
            });
    }
}
