<?php
namespace App\Events;

use App\Models\Episode;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class EpisodeCreated
{
    use SerializesModels, Dispatchable;

    public $episode;

    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }
}
