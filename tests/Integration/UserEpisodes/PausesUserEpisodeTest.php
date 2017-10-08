<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PausesUserEpisodeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_pauses_an_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id
        ]);

        $episode = factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        $userEpisode = factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->id,
            'episode_id' => $episode->id,
            'paused_at' => 0
        ]);

        $url = '/v1/users/' . $user->username . '/episodes/' . $episode->id . '/paused/' . 100;
        $this->put($url)->assertStatus(200);
        $this->assertEquals(100, $userEpisode->fresh()->paused_at);
    }

    /** @test */
    public function it_requires_valid_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id
        ]);

        $episode = factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->id,
            'episode_id' => $episode->id,
            'paused_at' => 0
        ]);

        $this->put('/v1/users/' . $user->username . '/episodes/42/paused/' . 100)
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_valid_user()
    {
        $this->authenticate();

        factory(Episode::class)->create();

        $this->put('/v1/users/notValidUser/episodes/1/paused/' . 100)
            ->assertStatus(404);
    }

    /** @test */
    public function user_must_follow_podcast_to_mark_pause_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $episode = factory(Episode::class)->create();

        $this->put('/v1/users/' . $user->username . '/episodes/'.$episode->id.'/paused/' . 100)
            ->assertStatus(404);
    }
}
