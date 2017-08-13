<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use App\Podty\UserEpisodes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveUserEpisodesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_retrieve_latests_feeds()
    {
        $this->get('/v1/users/user/episodes/1')
            ->seeStatusCode(401);
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
            ->seeStatusCode(200)
            ->seeJsonEquals([
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
}
