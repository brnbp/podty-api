<?php
namespace App\Events;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserFollowFeed
{
    use SerializesModels, Dispatchable;

    public $user;

    public $feed;

    public function __construct(User $user, Feed $feed)
    {
        $this->user = $user;
        $this->feed = $feed;
    }
}
