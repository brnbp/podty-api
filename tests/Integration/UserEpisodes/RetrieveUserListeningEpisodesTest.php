<?php

namespace Tests\Integration\UserEpisodes;

use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RetrieveUserListeningEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_requires_authenticated_client_to_make_request()
    {
        $this->get('/v1/users/randomuser/episodes/listening')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_in_progress_episodes()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $userFeeds = factory(UserFeed::class, 3)->create(['user_id' => $user->id]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->first()->id,
            'paused_at'    => 50,
        ]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->last()->id,
            'paused_at'    => 150,
        ]);

        $response = $this->get('/v1/users/'.$user->username.'/episodes/listening')
            ->assertJsonStructure([
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
                        ],
                    ],
                ],
            ]);

        $response = collect(json_decode($response->getContent())->data);

        $this->assertCount(2, $response);
    }

    /** @test */
    public function it_returns_404_when_user_has_zero_episodes_in_progress()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $userFeeds = factory(UserFeed::class, 3)->create(['user_id' => $user->id]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->first()->id,
            'paused_at'    => 0,
        ]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->last()->id,
            'paused_at'    => 0,
        ]);

        $this->get('/v1/users/'.$user->username.'/episodes/listening')
            ->assertStatus(404);
    }
}
