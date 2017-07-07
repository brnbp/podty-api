<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class FeedsTest extends TestCase
{
    use WithoutMiddleware;

    public function testReturnOneFeedByName()
    {
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
        $this->json('GET', '/v1/feeds/15')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    $this->getDefaultFeedStructure()
                ]
            ]);
    }

    public function testReturnLatestsFeeds()
    {
        $this->json('GET', '/v1/feeds/latest')
            ->seeStatusCode(200)
            ->seeJsonStructure($this->getDefaultStructure());
    }

    public function testReturnTopestsFeeds()
    {
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
