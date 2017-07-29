<?php
namespace Tests\Integration\UserFeeds;

use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserFeedsRepository;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveUserFeedsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_user_feeds()
    {
        $user = factory(User::class)->create();
        
        $this->get('v1/users/' . $user->username . '/feeds')
            ->assertResponseStatus(401);
    }
    
    /** @test */
    public function an_user_have_no_feeds()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $this->get('v1/users/' . $user->username . '/feeds')
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function an_user_have_feeds()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $feed = factory(Feed::class)->create();
        UserFeedsRepository::create($feed->id, $user);
        
        $this->get('v1/users/' . $user->username . '/feeds')
            ->seeJson([
                'data' => [
                    [
                        'id' => $feed->id,
                        'name' => $feed->name,
                        'slug' => $feed->slug,
                        'thumbnail_30' => $feed->thumbnail_30,
                        'thumbnail_60' => $feed->thumbnail_60,
                        'thumbnail_100' => $feed->thumbnail_100,
                        'thumbnail_600' => $feed->thumbnail_600,
                        'total_episodes' => (string) $feed->total_episodes,
                        'last_episode_at' => (string) $feed->last_episode_at,
                        'listen_all' => (string) 0
                    ]
                ]
            ])
            ->assertResponseStatus(200);
    }
    
    /** @test */
    public function it_retrieves_one_feed()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $feed = factory(Feed::class)->create();
        UserFeedsRepository::create($feed->id, $user);
        
        $this->get('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->seeJson([
                'data' => [
                    [
                        'id' => $feed->id,
                        'name' => $feed->name,
                        'slug' => $feed->slug,
                        'thumbnail_30' => $feed->thumbnail_30,
                        'thumbnail_60' => $feed->thumbnail_60,
                        'thumbnail_100' => $feed->thumbnail_100,
                        'thumbnail_600' => $feed->thumbnail_600,
                        'total_episodes' => (string) $feed->total_episodes,
                        'last_episode_at' => (string) $feed->last_episode_at,
                        'listen_all' => (string) 0
                    ]
                ]
            ])
            ->assertResponseStatus(200);
    }
    
    /** @test */
    public function it_gives_404_when_retrieving_non_existent_feed_by_id()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $this->get('v1/users/' . $user->username . '/feeds/1')
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function it_gives_404_when_retrieving_feed_that_user_not_follow()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $feed = factory(Feed::class)->create();
        
        $this->get('v1/users/' . $user->username . '/feeds/' . $feed->id)
            ->assertResponseStatus(404);
    }
}
