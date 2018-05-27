<?php

namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreatesUserEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_make_request()
    {
        $this->post('/v1/users/user/episodes/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_creates_episodes()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id'    => $user->id,
            'listen_all' => true,
        ]);

        $episode = factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id,
        ]);

        $this->post('/v1/users/'.$user->username.'/episodes/'.$episode->id)
            ->assertStatus(201);

        $this->assertFalse($userFeeds->fresh()->listen_all);
    }

    /** @test */
    public function it_requires_valid_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create(['user_id' => $user->id]);

        factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id,
        ]);

        $this->post('/v1/users/'.$user->username.'/episodes/42')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_valid_user()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $this->post('/v1/users/fakeUser/episodes/'.$episode->id)
            ->assertStatus(404);
    }

    /** @test */
    public function user_must_follow_podcast_to_attach_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $episode = factory(Episode::class)->create();

        $this->post('/v1/users/'.$user->username.'/episodes/'.$episode->id)
            ->assertStatus(404);
    }
}
