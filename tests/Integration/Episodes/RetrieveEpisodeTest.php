<?php
namespace Tests\Integration\Episodes;

use App\Models\Episode;
use App\Models\Feed;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveEpisodeTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_episode()
    {
        $this->get('/v1/episodes/1')
            ->seeStatusCode(401);
    }
    
    /** @test */
    public function it_retrieves_specific_episode()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $episode = factory(Episode::class)->create([
            'feed_id' => $feed->id
        ]);
    
        $response = $this->get('/v1/episodes/1')
                        ->seeStatusCode(200);
    
        $response = json_decode($response->response->getContent(), true);
        
        $expected = (new FeedTransformer)->transform($feed);
        $expected['episodes'] = (new EpisodeTransformer())->transform($episode);
        
        $this->assertEquals([
            'data' => $expected
        ], $response);
    }
    
    /** @test */
    public function it_returns_404_when_retrieving_unexistent_episode()
    {
        $this->authenticate();
        
        $this->get('/v1/episodes/1')
            ->seeStatusCode(404);
    }
}
