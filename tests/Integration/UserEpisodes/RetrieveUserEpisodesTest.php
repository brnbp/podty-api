<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveUserEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_make_request()
    {
        $this->get('/v1/users/user/episodes/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_one_episode()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'listen_all' => false,
        ]);

        $episode = factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        $userEpisode = factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeeds->id,
            'episode_id' => $episode->id,
        ]);

        $this->get('/v1/users/' . $user->username . '/episodes/' . $episode->id)
            ->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'id' => $episode->id,
                    'title' => $episode->title,
                    'link' => $episode->link,
                    'published_at' => (string) $episode->published_date,
                    'content' => $episode->content,
                    'summary' => $episode->summary,
                    'image' => $episode->image,
                    'duration' => $episode->duration,
                    'media_url' => $episode->media_url,
                    'media_length' => (string) $episode->media_length,
                    'media_type' => $episode->media_type,
                    "paused_at" => (string) $userEpisode->paused_at
                ]
            ]);
    }

    /** @test */
    public function it_retrieves_all_episodes_from_feed()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

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
            'paused_at' => 99
        ]);

        $feed = $userFeeds->feed()->first();
        $response = $this->get('/v1/users/' . $user->username . '/feeds/' .$userFeeds->feed_id . '/episodes')
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals([
            'data' => [
                'id' => $feed->id,
                'name' => $feed->name,
                'slug' => $feed->slug,
                'url' => $feed->url,
                'thumbnail_30' => $feed->thumbnail_30,
                'thumbnail_60' => $feed->thumbnail_60,
                'thumbnail_100' => $feed->thumbnail_100,
                'thumbnail_600' => $feed->thumbnail_600,
                'total_episodes' => $feed->total_episodes,
                'listeners' => $feed->listeners,
                'last_episode_at' => (string) $feed->last_episode_at,
                'episodes' => [
                    [
                        "id" => $episode->id,
                        "feed_id" => (string) $episode->feed_id,
                        "title" => $episode->title,
                        "link" => $episode->link,
                        "published_date" => (string) $episode->published_date,
                        "summary" => $episode->summary,
                        "content" => $episode->content,
                        "image" => $episode->image,
                        "duration" => $episode->duration,
                        "media_url" => $episode->media_url,
                        "media_length" => (string) $episode->media_length,
                        "media_type" => $episode->media_type,
                        "paused_at" => "99",
                        "avg_rating" => '0.0',
                    ]
                ]
            ]
        ], $response);
    }

    /** @test */
    public function it_retrieves_none_episodes_from_feed()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'listen_all' => false,
        ]);

        factory(Episode::class)->create([
            'feed_id' => $userFeeds->feed_id
        ]);

        $this->get('/v1/users/' . $user->username . '/feeds/' .$userFeeds->feed_id . '/episodes')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_an_valid_user()
    {
        $this->authenticate();

        $feed = factory(Feed::class)->create();

        $this->get('/v1/users/invalidUser/feeds/' .$feed->id . '/episodes')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_an_valid_feed()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $this->get('/v1/users/' . $user->username . '/feeds/42/episodes')
            ->assertStatus(404);
    }

    /** @test */
    public function feed_must_have_episodes()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $feed = factory(Feed::class)->create();

        factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'feed_id' => $feed->id,
            'listen_all' => false,
        ]);

        $this->get('/v1/users/' . $user->username . '/feeds/' . $feed->id . '/episodes')
            ->assertStatus(404);
    }

    /** @test */
    public function it_must_follow_feed()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $feed = factory(Feed::class)->create();
        factory(Episode::class)->create([
           'feed_id' => $feed->id
        ]);

        $this->get('/v1/users/' . $user->username . '/feeds/' . $feed->id . '/episodes')
            ->assertStatus(404);
    }
}
