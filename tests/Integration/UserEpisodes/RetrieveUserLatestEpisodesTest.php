<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveUserLatestEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_requires_authenticated_client_to_make_request()
    {
        $this->get('/v1/users/randomuser/episodes/latests')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_in_progress_episodes()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create();
        $episode = factory(Episode::class)->create([
            'feed_id' => $feed->id,
        ]);
        $userFeeds = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'feed_id' => $feed->id,
        ]);

        UserEpisode::create([
            'user_feed_id' => $userFeeds->id,
            'episode_id' => $episode->id,
            'paused_at' => 1,
        ]);

        $response = $this->get('/v1/users/' . $user->username . '/episodes/latests')
            ->assertExactJson([
                'data' => [
                    [
                        'id' => (string) $feed['id'],
                        'name' => $feed['name'],
                        'description' => $feed['description'],
                        'slug' => $feed['slug'],
                        'url' => $feed['url'],
                        'color' => $feed['main_color'],
                        'thumbnail_30' => $feed['thumbnail_30'],
                        'thumbnail_60' => $feed['thumbnail_60'],
                        'thumbnail_100' => $feed['thumbnail_100'],
                        'thumbnail_600' => $feed['thumbnail_600'],
                        'total_episodes' => (string) $feed['total_episodes'],
                        'listeners' => (string) $feed['listeners'],
                        'last_episode_at' => (string) $feed['last_episode_at'],
                        'episode' => [
                            'id' => $episode['id'],
                            'title' => $episode['title'],
                            'link' => $episode['link'],
                            'published_at' => (string) $episode['published_date'],
                            'content' => $episode['content'],
                            'summary' => $episode['summary'],
                            'image' => $episode['image'],
                            'duration' => $episode['duration'],
                            'media_url' => $episode['media_url'],
                            'media_length' => (string) $episode['media_length'],
                            'media_type' => $episode['media_type'],
                            'paused_at' => "1",
                        ]
                    ]
                ]
            ]);


        $response = collect(json_decode($response->getContent())->data);

        $this->assertCount(1, $response);
    }

    /** @test */
    public function it_returns_404_when_user_has_zero_episodes_in_progress()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $this->get('/v1/users/' . $user->username . '/episodes/latests')
            ->assertStatus(404);
    }
}
