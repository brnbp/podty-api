<?php
namespace Tests\Integration\Episodes;

use App\Models\Episode;
use App\Models\Feed;
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
            ->assertJsonFragment(['Invalid Filter Query'])
            ->assertStatus(400);
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
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true)['data'];

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
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true)['data'];

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
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true)['data'];

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
            'published_date' => (string) Carbon::now()->subDay(2)
        ]);
        factory(Episode::class)->create([
            'feed_id' => $feed->id,
            'published_date' => (string) Carbon::now()->subDay(1)
        ]);

        $response = $this->get('/v1/feeds/1/episodes?order=ASC')
            ->assertStatus(200);

        $episodes = json_decode($response->getContent(), true)['data']['episodes'];

        $this->assertEquals((string) Carbon::now()->subDay(3), (string) $episodes[0]['published_at']);
        $this->assertEquals((string) Carbon::now()->subDay(2), (string) $episodes[1]['published_at']);
        $this->assertEquals((string) Carbon::now()->subDay(1), (string) $episodes[2]['published_at']);
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
            ->assertJsonFragment([
                'title' => 'Specific Episode'
            ])
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true)['data'];

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
            ->assertStatus(404);
    }
}
