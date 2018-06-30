<?php
namespace Tests\Integration\UserFeeds;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserFeedsRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MarksFeedAsListenedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_allow_user_to_follows_feed()
    {
        $this->put('v1/users/someuser/feeds/1/listenAll')
            ->assertStatus(401);
    }

    /** @test */
    public function it_marks_user_feed_as_all_listened()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $feed = factory(Feed::class)->create();
        factory(Episode::class, 3)->create(['feed_id' => $feed->id]);
        UserFeedsRepository::create($feed->id, $user);

        $this->put('v1/users/' . $user->username . '/feeds/' . $feed->id . '/listenAll')
            ->assertStatus(200);

        $userFeeds = $user->feeds()->find($feed->id);

        $this->assertCount(0, $userFeeds->episodes);
        $this->assertTrue($userFeeds->listen_all);
    }
}
