<?php
namespace Tests\Integration\Episodes;

use App\Models\Episode;
use App\Models\Feed;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveLatestsEpisodesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_latests_episode()
    {
        $this->get('/v1/episodes/latest')
            ->seeStatusCode(401);
    }
    
    /** @test */
    public function it_retrieves_latests_episode()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $episodeNewest = factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => Carbon::now()
        ]);
        $episodeOldest = factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => Carbon::now()->subDay(1)
        ]);
        
        $response = $this->get('/v1/episodes/latest')
                        ->seeStatusCode(200);
    
        $response = json_decode($response->response->getContent(), true);
        
        $expectedNewest = (new FeedTransformer)->transform($feed);
        $expectedNewest['episodes'][] = (new EpisodeTransformer())->transform($episodeNewest);
    
        $expectedOldest = (new FeedTransformer)->transform($feed);
        $expectedOldest['episodes'][] = (new EpisodeTransformer())->transform($episodeOldest);

        $this->assertEquals([
            'data' => [
                $expectedNewest,
                $expectedOldest,
            ]
        ], $response);
    }
    
    /** @test */
    public function it_returns_404_when_retrieving_unexistent_episode()
    {
        $this->authenticate();
        
        $this->get('/v1/episodes/latest')
            ->seeStatusCode(404);
    }
    
    /** @test */
    public function it_requires_valid_filter()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class, 2)->create([
            'feed_id' => $feed->id
        ]);
        
        $this->get('/v1/episodes/latest?invalidFilter=true')
            ->seeStatusCode(400);
    }
}
