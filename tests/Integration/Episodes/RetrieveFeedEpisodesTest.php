<?php
namespace Tests\Integration\Episodes;

use App\Models\Episode;
use App\Models\Feed;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveFeedEpisodesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_latests_episode()
    {
        $this->get('/v1/feeds/1/episodes')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_episodes_from_feed()
    {
        $this->authenticate();

        $feed = factory(Feed::class)->create();

        $episodes = factory(Episode::class)->create([
            'feed_id' => $feed->id,
        ]);

        $response = $this->get('/v1/feeds/1/episodes')
                        ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $expected = (new FeedTransformer)->transform($feed);
        $expected['episodes'][] = (new EpisodeTransformer())->transform($episodes);

        $this->assertEquals([
            'data' => $expected
        ], $response);
    }

    /** @test */
    public function it_returns_404_when_retrieving_unexistent_episodes_from_given_feed()
    {
        $this->authenticate();

        factory(Feed::class)->create();

        $this->get('/v1/feeds/1/episodes')
            ->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_when_retrieving_episodes_from_unexistent_feed()
    {
        $this->authenticate();

        $this->get('/v1/feeds/1/episodes')
            ->assertStatus(404);
    }
}

