<?php
namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Models\UserFriend;
use App\Repositories\UserFriendsRepository;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserFriendsRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_retrieves_newest_friends()
    {
        $user = factory(User::class)->create();
        
        $friends = factory(User::class, 4)->create();
        
        $friendAtWeeks = 3;
        $friends->map(function($friend) use($user, &$friendAtWeeks) {
            UserFriend::firstOrCreate([
                'user_id' => $friend->id,
                'friend_user_id' => $user->id,
                'created_at' => (string) Carbon::create()->subWeeks($friendAtWeeks)
            ]);
            $friendAtWeeks = $friendAtWeeks == 1 ? 1 : $friendAtWeeks - 2;
        });
        
        $newFollowers = UserFriendsRepository::newestFollowers($user);
        
        $this->assertCount(3, $newFollowers);
    }
}
