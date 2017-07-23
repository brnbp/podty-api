<?php
namespace Tests\Integration\Feeds;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FeedsTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;
    
    /** @test */
    public function it_returns_feed_by_name()
    {
        $feed = factory(\App\Models\Feed::class)->create([
            'name' => 'devnaestrada',
            'slug' => 'devnaestrada',
        ]);
    
        factory(\App\Models\Episode::class)->times(6)->create([
            'feed_id' => $feed->id
        ]);
    
        $response = $this->json('GET', '/v1/feeds/name/devnaestrada')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
        $response = collect(json_decode($response->response->getContent())->data);
        $this->assertCount(1, $response);
    }
    
    /** @test */
    public function it_returns_feed_by_id()
    {
        $feed = factory(\App\Models\Feed::class)->create([
            'name' => 'devnaestrada',
            'slug' => 'devnaestrada',
        ]);
    
        factory(\App\Models\Episode::class)->times(2)->create([
            'feed_id' => $feed->id
        ]);
    
        $this->json('GET', '/v1/feeds/1')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
    }
    
    /** @test */
    public function it_returns_latests_feeds()
    {
        factory(\App\Models\Episode::class)->times(3)->create();
        $response = $this->json('GET', '/v1/feeds/latest')
            ->seeStatusCode(200)
            ->seeJsonStructure($this->getDefaultStructure());
    
        $response = collect(json_decode($response->response->getContent())->data);
        $this->assertCount(3, $response);
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
