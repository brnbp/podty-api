<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * This event represents a moment when a user rated an specific episode
 */
class UserRatedEpisode
{
    use SerializesModels, Dispatchable;

    private $user;

    private $episode;

    private $rate;

    public function __construct($user, $episode, $rate)
    {
        $this->user = $user;
        $this->episode = $episode;
        $this->rate = $rate;
    }
}
