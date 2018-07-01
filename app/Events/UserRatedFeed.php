<?php
namespace App\Http\Controllers\v1;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * This event represents a moment when a user rated a feed
 */
class UserRatedFeed
{
    use SerializesModels, Dispatchable;

    public $user;

    public $feed;

    public $rate;

    public function __construct(User $user, Feed $feed, float $rate)
    {
        $this->user = $user;
        $this->feed = $feed;
        $this->rate = $rate;
    }
}
