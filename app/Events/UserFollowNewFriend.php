<?php
namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * This event represents the act of a user start to follow another user
 */
class UserFollowNewFriend
{
    use SerializesModels, Dispatchable;

    public $user;

    public $friend;

    public function __construct(User $user, User $friend)
    {
        $this->user = $user;
        $this->friend = $friend;
    }
}
