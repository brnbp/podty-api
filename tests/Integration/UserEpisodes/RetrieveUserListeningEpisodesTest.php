<?php
namespace Tests\Integration;

use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RetrieveUserListeningEpisodesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_retrieves_in_progress_episodes()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $userFeeds = factory(UserFeed::class, 3)->create(['user_id' => $user->id]);
        
        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->first()->id,
            'paused_at' => 50
        ]);
    
        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->last()->id,
            'paused_at' => 150
        ]);
        
        $response = $this->get('/v1/users/' . $user->username . '/episodes/listening');
        $response = collect(json_decode($response->response->getContent())->data);

        $this->assertCount(2, $response);
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
