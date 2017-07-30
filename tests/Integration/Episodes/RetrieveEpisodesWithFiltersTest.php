<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\Feed;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveEpisodesWithFiltersTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_requires_valid_filter()
    {
        $this->authenticate();
        
        factory(Feed::class)->create();
        
        $this->get('/v1/feeds/1/episodes?filter=invalid')
            ->seeText('Invalid Filter Query')
            ->seeStatusCode(400);
    }
    
    /** @test */
    public function it_limits_to_one_result()
    {
        $this->authenticate();
    
        $feed = factory(Feed::class)->create();
    
        factory(Episode::class, 3)->create([
            'feed_id' => $feed->id
        ]);
    
        $response = $this->get('/v1/feeds/1/episodes?limit=1')
            ->seeStatusCode(200);
    
        $response = json_decode($response->response->getContent(), true)['data'];

        $this->assertCount(1, $response['episodes']);
    }
    
    /** @test */
    public function it_offsets_by_one()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class, 3)->create([
            'feed_id' => $feed->id
        ]);
        
        $response = $this->get('/v1/feeds/1/episodes?offset=1')
            ->seeStatusCode(200);
        
        $response = json_decode($response->response->getContent(), true)['data'];

        $this->assertCount(2, $response['episodes']);
    }
    
    /** @test */
    public function it_offsets_by_one_and_limits_to_one_result()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class, 3)->create([
            'feed_id' => $feed->id
        ]);
        
        $response = $this->get('/v1/feeds/1/episodes?offset=1&limit=1')
            ->seeStatusCode(200);
        
        $response = json_decode($response->response->getContent(), true)['data'];
        
        $this->assertCount(1, $response['episodes']);
    }
    
    /** @test */
    public function it_reverses_episodes_orders()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => Carbon::now()->subDay(3)
        ]);
        factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => Carbon::now()->subDay(2)
        ]);
        factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => Carbon::now()->subDay(1)
        ]);
        
        $response = $this->get('/v1/feeds/1/episodes?order=ASC')
            ->seeStatusCode(200);
        
        $episodes = json_decode($response->response->getContent(), true)['data']['episodes'];
        
        $this->assertEquals(Carbon::now()->subDay(3), $episodes[0]['published_at']);
        $this->assertEquals(Carbon::now()->subDay(2), $episodes[1]['published_at']);
        $this->assertEquals(Carbon::now()->subDay(1), $episodes[2]['published_at']);
    }
    
    /** @test */
    public function it_searches_for_specific_episode()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class)->create([
            'title' => 'Not Wanted Episode',
            'feed_id' => $feed->id
        ]);
        factory(Episode::class)->create([
            'title' => 'Specific Episode',
            'feed_id' => $feed->id
        ]);
        
        $response = $this->get('/v1/feeds/1/episodes?term=Specific+Episode')
            ->seeJson([
                'title' => 'Specific Episode'
            ])
            ->seeStatusCode(200);
        
        $response = json_decode($response->response->getContent(), true)['data'];
        
        $this->assertCount(1, $response['episodes']);
    }
    
    /** @test */
    public function it_returns_404_searching_for_specific_episode_that_dont_exist()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        factory(Episode::class)->create([
            'title' => 'Not Wanted Episode',
            'feed_id' => $feed->id
        ]);
        factory(Episode::class)->create([
            'title' => 'Specific Episode',
            'feed_id' => $feed->id
        ]);
        
        $this->get('/v1/feeds/1/episodes?term=Another+Episode')
            ->seeStatusCode(404);
    }
}
