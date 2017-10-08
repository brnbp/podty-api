<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeletesUserEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_make_request()
    {
        $this->delete('/v1/users/user/episodes/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_deletes_an_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        factory(Episode::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'listen_all' => false,
        ]);

        $episode = factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->id,
            'episode_id' => $episode->id,
        ]);

        $this->delete('/v1/users/' . $user->username . '/episodes/' . $episode->id)
            ->assertStatus(200);

        $this->assertTrue($userFeeds->fresh()->listen_all);
    }

    /** @test */
    public function it_requires_valid_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create(['user_id' => $user->id]);

        factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        $this->delete('/v1/users/' . $user->username . '/episodes/42')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_valid_user()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $this->delete('/v1/users/fakeUser/episodes/' . $episode->id)
            ->assertStatus(404);
    }

    /** @test */
    public function user_must_follow_podcast_to_attach_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $episode = factory(Episode::class)->create();

        $this->delete('/v1/users/' . $user->username . '/episodes/' . $episode->id)
            ->assertStatus(404);
    }
}
