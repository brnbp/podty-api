<?php
namespace Tests\Integration\Feeds;

use App\Models\Feed;
use App\Transform\FeedTransformer;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveTopFeedsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_top_feeds()
    {
        factory(Feed::class)->create([
            'listeners' => 1,
            'last_episode_at' => (string) Carbon::now()->subDay(4),
        ]);
        factory(Feed::class)->create([
            'listeners' => 5,
            'last_episode_at' => (string) Carbon::now(),
        ]);
        
        $this->get('/v1/feeds/top')
            ->seeStatusCode(401);
    }
    
    /** @test */
    public function it_retrieves_top_feeds()
    {
        $this->authenticate();
    
        $thirdFeed = factory(Feed::class)->create([
            'listeners' => 0,
            'last_episode_at' => (string) Carbon::now()->subDay(5),
        ]);
        $secondFeed = factory(Feed::class)->create([
            'listeners' => 1,
            'last_episode_at' => (string) Carbon::now()->subDay(4),
        ]);
        $firstFeed = factory(Feed::class)->create([
            'listeners' => 5,
            'last_episode_at' => (string) Carbon::now(),
        ]);
        
        $response = $this->get('/v1/feeds/top')
            ->seeStatusCode(200)
            ->seeJsonStructure($this->getDefaultStructure());
    
        $response = json_decode($response->response->getContent(), true);
        
        
        $this->assertEquals([
            'data' => [
                (new FeedTransformer)->transform($firstFeed->toArray()),
                (new FeedTransformer)->transform($secondFeed->toArray()),
                (new FeedTransformer)->transform($thirdFeed->toArray()),
            ]
        ], $response);
    }
    
    /** @test */
    public function it_returns_404_when_retrieving_top_feeds_having_no_feeds()
    {
        $this->authenticate();
        
        $this->get('/v1/feeds/top')
            ->seeStatusCode(404);
    }
    
    private function getDefaultStructure()
    {
        return [
            'data' => [
                '*' => $this->getDefaultFeedStructure()
            ]
        ];
    }

    private function getDefaultFeedStructure()
    {
        return [
            'id',
            'name',
            'url',
            'thumbnail_30',
            'thumbnail_60',
            'thumbnail_100',
            'thumbnail_600',
            'total_episodes',
            'listeners',
            'last_episode_at'
        ];
    }
}
