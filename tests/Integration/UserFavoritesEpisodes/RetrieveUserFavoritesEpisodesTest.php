<?php
namespace Tests\Integration\UserFavoritesEpisodes;

use Carbon\Carbon;

class RetrieveUserFavoritesEpisodesTest extends UserFavoritesEpisodes
{
    /** @test */
    public function it_requires_authenticated_client_to_make_request()
    {
        $this->get('/v1/users/randomuser/episodes/favorites')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_user_favorites_episodes()
    {
        $this->authenticate();

        $this->post('/v1/users/' . $this->user->username . '/episodes/' . $this->episode->id . '/favorite');

        $response = $this->get('/v1/users/' . $this->user->username . '/episodes/favorites');

        $response = json_decode($response->getContent(), true);
        $this->assertEquals([
            'data' => [
                [
                    "id" => 1,
                    "user_id" => '1',
                    "feed_id" => (string) $this->episode->feed_id,
                    "episode_id" => (string) $this->episode->id,
                    "created_at" => (string) Carbon::now(),
                    "episode" => [
                        "id" => $this->episode->id,
                        "feed_id" => $this->episode->feed_id,
                        "title" => $this->episode->title,
                        "link" => $this->episode->link,
                        "published_date" => $this->episode->published_date,
                        "summary" => $this->episode->summary,
                        "content" => $this->episode->content,
                        "image" => $this->episode->image,
                        "duration" => $this->episode->duration,
                        "media_url" => $this->episode->media_url,
                        "media_length" => $this->episode->media_length,
                        "media_type" => $this->episode->media_type,
                        "avg_rating" => 0.0,
                    ],
                    "feed" => [
                        "id" => $this->userFeeds->feed->id,
                        "name" => $this->userFeeds->feed->name,
                        "slug" => $this->userFeeds->feed->slug,
                        "url" => $this->userFeeds->feed->url,
                        "thumbnail_30" => $this->userFeeds->feed->thumbnail_30,
                        "thumbnail_60" => $this->userFeeds->feed->thumbnail_60,
                        "thumbnail_100" => $this->userFeeds->feed->thumbnail_100,
                        "thumbnail_600" => $this->userFeeds->feed->thumbnail_600,
                        "total_episodes" => $this->userFeeds->feed->total_episodes,
                        "last_episode_at" => $this->userFeeds->feed->last_episode_at,
                        "listeners" => $this->userFeeds->feed->listeners,
                        "updated_at" => $this->userFeeds->feed->updated_at,
                        "avg_rating" => 0.0,
                    ]
                ]
            ]
        ], $response);
    }

    /** @test */
    public function it_retrieves_none_user_favorites_episodes()
    {
        $this->authenticate();

        $this->get('/v1/users/' . $this->user->username . '/episodes/favorites')
            ->assertStatus(404);
    }

    /** @test */
    public function it_cannot_retrieve_favorites_episodes_for_nonexistent_user()
    {
        $this->authenticate();

        $this->get('/v1/users/nonUser/episodes/favorites')
            ->assertStatus(404);
    }
}
