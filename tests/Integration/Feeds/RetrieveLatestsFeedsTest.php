<?php

namespace Tests\Integration\Feeds;

use App\Models\Episode;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RetrieveLatestsFeedsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_latests_feeds()
    {
        $this->get('/v1/feeds/latest')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_latests_feeds()
    {
        $this->authenticate();

        factory(Episode::class, 3)->create();

        $response = $this->get('/v1/feeds/latest')
                        ->assertStatus(200)
                        ->assertJsonStructure($this->getDefaultStructure());

        $response = collect(json_decode($response->getContent())->data);
        $this->assertCount(3, $response);
    }

    /** @test */
    public function it_returns_404_when_retrieving_latests_feeds_having_no_feeds()
    {
        $this->authenticate();

        $this->get('/v1/feeds/latest')
            ->assertStatus(404);
    }

    private function getDefaultStructure()
    {
        return [
            'data' => [
                '*' => $this->getDefaultFeedStructure(),
            ],
        ];
    }

    private function getDefaultFeedStructure()
    {
        return [
            'id',
            'name',
            'url',
            'description',
            'thumbnail_30',
            'thumbnail_60',
            'thumbnail_100',
            'thumbnail_600',
            'total_episodes',
            'listeners',
            'last_episode_at',
        ];
    }
}
