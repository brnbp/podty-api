<?php
namespace App\Jobs;

use App\Models\Episode;
use App\Repositories\EpisodesRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddNewEpisodeToListeners extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    private $episode;

    public function __construct(Episode $episode)
    {
        $this->queue = 'high';
        $this->episode = $episode;
    }

    public function handle(EpisodesRepository $repository)
    {
        $repository->addToListeners($this->episode);
    }
}
