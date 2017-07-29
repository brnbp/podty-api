<?php
namespace Tests\Integration\UserFeeds;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FollowUserFeedsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_allow_user_to_follows_feed()
    {
        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create();
        
        $this->post('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->assertResponseStatus(401);
    }
    
    /** @test */
    public function it_returns_404_when_non_existent_user_tries_to_follow_feed()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $this->post('v1/users/randomuser/feeds/' . $feed->id)
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function it_returns_404_when_trying_to_follow_non_existent_feed()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
    
        $this->post('v1/users/' . $user->username . '/feeds/2')
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function an_user_can_follow_a_feed()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create([
            'listeners' => 0,
            'total_episodes' => 3,
        ]);
        factory(Episode::class, 3)->create(['feed_id' => $feed->id]);
        
        $this->post('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->seeJson([
                'data' => [
                    'id' => 1,
                    'feed_id' => (string) $feed->id,
                    'user_id' => (string) $user->id,
                    'listen_all' => false,
                ]
            ])
            ->assertResponseStatus(200);
        
        $this->assertEquals(1, $user->fresh()->podcasts_count);
    
        $userFeeds = $user->feeds()->find($feed->id);
        
        $this->assertCount(3, $userFeeds->episodes);
    }

    /** @test */
    public function it_increases_listener_count_for_feed_when_user_follows_him()
    {
        $this->authenticate();
    
        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create([
            'listeners' => 0
        ]);
    
        $this->post('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->assertResponseStatus(200);
        
        $this->assertEquals(1, $feed->fresh()->listeners);
    }
}
