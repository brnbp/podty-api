<?php
namespace App\Events;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * This event represents a moment when a user is listening an episode.
 */
class UserListeningEpisode
{
    use SerializesModels, Dispatchable;

    private $user;

    public $episode;

    public function __construct(User $user, Episode $episode)
    {
        $this->user = $user;
        $this->episode = $episode;
    }
}
