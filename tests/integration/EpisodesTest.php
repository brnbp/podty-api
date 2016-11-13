<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class EpisodesTest extends TestCase
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
            'last_episode_at',
            'last_search'
        ];
    }

}
