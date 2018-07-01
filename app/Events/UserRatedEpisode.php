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

    public $user;

    public $episode;

    public $rate;

    public function __construct($user, $episode, $rate)
    {
        $this->user = $user;
        $this->episode = $episode;
        $this->rate = $rate;
    }
}
