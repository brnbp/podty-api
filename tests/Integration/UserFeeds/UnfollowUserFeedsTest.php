<?php
namespace Tests\Integration\UserFeeds;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserFeedsRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UnfollowUserFeedsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_allow_user_to_follows_feed()
    {
        $this->delete('v1/users/someuser/feeds/1')
            ->assertResponseStatus(401);
    }
    
    /** @test */
    public function it_returns_404_when_non_existent_user_tries_to_unfollow_feed()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $this->delete('v1/users/randomuser/feeds/' . $feed->id)
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function it_returns_404_when_trying_to_follow_non_existent_feed()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        
        $this->delete('v1/users/' . $user->username . '/feeds/2')
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function an_user_can_unfollow_a_feed()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create();
        factory(Episode::class, 3)->create(['feed_id' => $feed->id]);
        
        UserFeedsRepository::create($feed->id, $user);
        
        $this->delete('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->assertResponseStatus(200);
        
        $this->assertEquals(0, $user->fresh()->podcasts_count);
    
        $this->assertCount(0, $user->feeds()->get());
    }
    
    /** @test */
    public function it_decreases_listener_count_for_feed_when_user_unfollows_him()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create([
            'listeners' => 0
        ]);
    
        UserFeedsRepository::create($feed->id, $user);
        
        $this->delete('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->assertResponseStatus(200);
        
        $this->assertEquals(0, $feed->fresh()->listeners);
    }
}
