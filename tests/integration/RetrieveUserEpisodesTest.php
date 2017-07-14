<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RetrieveUserEpisodesTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;
    
    /** @test */
    public function it_retrieves_in_progress_episodes()
    {
        $episodes = factory(\App\Models\Episode::class)->times(6)->create();
        
        $user = factory(\App\Models\User::class)->create();
        
        $episodes->each(function($episode) use ($user) {
            $this->post('/v1/users/' . $user->username . '/feeds/' . $episode->feed_id);
            if ($episode->id <= 2) return;
            $this->put('/v1/users/' . $user->username . '/episodes/' . $episode->id . '/paused/' . random_int(100, 100000));
        });
        
        $response = $this->get('/v1/users/' . $user->username . '/episodes/listening');
        $response = collect(json_decode($response->response->getContent())->data);
        
        $this->assertCount(4, $response);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'url',
                    'thumbnail_30',
                    'thumbnail_60',
                    'thumbnail_100',
                    'thumbnail_600',
                    'total_episodes',
                    'listeners',
                    'last_episode_at',
                    'episode' => [
                        'id',
                        'title',
                        'link',
                        'published_at',
                        'content',
                        'summary',
                        'image',
                        'duration',
                        'media_url',
                        'media_length',
                        'media_type',
                        'paused_at',
                    ]
                ]
            ]
        ]);
    }
}
