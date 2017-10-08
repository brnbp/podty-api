<?php
namespace Tests\Integration\Feeds;

use App\Models\Episode;
use App\Models\Feed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveFeedsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_feed_by_name()
    {
        $this->get('/v1/feeds/name/somefeed')
            ->assertStatus(401);
    }

    /** @test */
    public function unauthenticated_client_cannot_retrieve_feed_by_id()
    {
        $this->get('/v1/feeds/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_feed_by_name()
    {
        $this->authenticate();

        $feed = factory(Feed::class)->create([
            'name' => 'devnaestrada',
            'slug' => 'devnaestrada',
        ]);

        factory(Episode::class, 6)->create([
            'feed_id' => $feed->id
        ]);

        $response = $this->get('/v1/feeds/name/devnaestrada')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
        $response = collect(json_decode($response->getContent())->data);
        $this->assertCount(1, $response);
    }

    /** @test */
    public function it_returns_404_when_retrieving_non_existent_feed_by_name()
    {
        $this->authenticate();

        $this->get('/v1/feeds/name/anotherfeed')
            ->assertStatus(404);
    }

    /** @test */
    public function it_returns_feed_by_id()
    {
        $this->authenticate();

        $feed = factory(Feed::class)->create();

        factory(Episode::class, 3)->create([
            'feed_id' => $feed->id
        ]);

        $this->get('/v1/feeds/1')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_when_retrieving_non_existent_feed_by_id()
    {
        $this->authenticate();

        $this->get('/v1/feeds/1')
            ->assertStatus(404);
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
