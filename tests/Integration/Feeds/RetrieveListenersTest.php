<?php
namespace Tests\Integration\Feeds;

use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserFeedsRepository;
use App\Transform\UserTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveListenersTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_listeners_for_feed()
    {
        $feed = factory(Feed::class)->create();
        $user = factory(User::class)->create();
        
        UserFeedsRepository::create($feed->id, $user);
        
        $this->get('/v1/feeds/1/listeners')
            ->seeStatusCode(401);
    }
    
    /** @test */
    public function it_retrieves_listeners_for_feed()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $users = factory(User::class, 2)->create();
        
        $users->each(function($user) use($feed) {
            UserFeedsRepository::create($feed->id, $user);
        });
        
        $this->get('/v1/feeds/1/listeners')
            ->seeJsonEquals([
                'data' => [
                    (new UserTransformer())->transform($users->first()->fresh()),
                    (new UserTransformer())->transform($users->last()->fresh()),
                ]
            ])
            ->seeStatusCode(200);
    }
    
    /** @test */
    public function it_returns_404_when_retrieving_listeners_for_feeds_having_no_listeners()
    {
        $this->authenticate();
        
        factory(Feed::class)->create();
        
        $this->get('/v1/feeds/1/listeners')
            ->seeStatusCode(404);
    }
    
    /** @test */
    public function it_returns_404_when_retrieving_listeners_for_not_found_feed()
    {
        $this->authenticate();
        
        $this->get('/v1/feeds/1/listeners')
            ->seeStatusCode(404);
    }
}
