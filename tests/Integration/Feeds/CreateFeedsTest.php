<?php
namespace Tests\Integration\Feeds;

use App\Models\Feed;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateFeedsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_an_feed()
    {
        $this->authenticate();

        $feed = factory(Feed::class)->make();

        $payload = [
            'name' => $feed->name,
            'itunes_id' => $feed->itunes_id,
            'url' => $feed->url,
            'thumbnail_30' => $feed->thumbnail_30,
            'thumbnail_60' => $feed->thumbnail_60,
            'thumbnail_100' => $feed->thumbnail_100,
            'thumbnail_600' => $feed->thumbnail_600,
        ];

        $this->post('/v1/feeds', $payload)
            ->assertStatus(201);
    }

    /** @test */
    public function it_required_some_attributes_to_create_feed()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();

        $feed = factory(Feed::class)->make();

        $payload = [
            'url' => $feed->url,
            'thumbnail_30' => $feed->thumbnail_30,
            'thumbnail_60' => $feed->thumbnail_60,
            'thumbnail_100' => $feed->thumbnail_100,
            'thumbnail_600' => $feed->thumbnail_600,
        ];

        $this->post('/v1/feeds', $payload)
            ->assertJsonFragment(['The given data was invalid.'])
            ->assertJsonFragment(['The name field is required.'])
            ->assertJsonFragment(['The itunes id field is required.'])
            ->assertStatus(422);
    }
}
