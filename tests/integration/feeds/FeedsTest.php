<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FeedsTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;
    
    public function testReturnOneFeedByName()
    {
        $feed = factory(\App\Models\Feed::class)->create([
            'name' => 'devnaestrada',
            'slug' => 'devnaestrada',
        ]);
        
        factory(\App\Models\Episode::class)->times(6)->create([
            'feed_id' => $feed->id
        ]);
        
        $this->json('GET', '/v1/feeds/name/devnaestrada')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
    }


    public function testReturnOneFeedById()
    {
        $feed = factory(\App\Models\Feed::class)->create([
            'name' => 'devnaestrada',
            'slug' => 'devnaestrada',
        ]);
    
        factory(\App\Models\Episode::class)->times(6)->create([
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

    public function testReturnLatestsFeeds()
    {
        factory(\App\Models\Episode::class)->times(6)->create();
        
        $this->json('GET', '/v1/feeds/latest')
            ->seeStatusCode(200)
            ->seeJsonStructure($this->getDefaultStructure());
    }

    public function testReturnTopestsFeeds()
    {
        factory(\App\Models\Episode::class)->times(6)->create();
        $this->json('GET', '/v1/feeds/latest')
            ->seeStatusCode(200)
            ->seeJsonStructure($this->getDefaultStructure());
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
