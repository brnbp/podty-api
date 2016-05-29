<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterEpisodesFeed extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var integer $id feed id */
    public $id;

    /** @var string $url feed url */
    public $url;

    /**
     * RegisterEpisodesFeed constructor.
     *
     * @param array $feed
     */
    public function __construct(array $feed)
    {
        $this->id = $feed['id'];
        $this->url = $feed['url'];
    }

    /**
     * Execute the job.
     *
     * @param Episode $episode
     */
    public function handle(Episode $episode)
    {
        $episode->storage($this->id, $this->url);
    }
}
