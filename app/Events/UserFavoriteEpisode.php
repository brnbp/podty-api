<?php
namespace App\Events;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * This event represents the moment that the user favorite some episode
 */
class UserFavoriteEpisode
{
    use SerializesModels, Dispatchable;

    public $user;

    public $episode;

    public function __construct(User $user, Episode $episode)
    {
        $this->user = $user;
        $this->episode = $episode;
    }
}
