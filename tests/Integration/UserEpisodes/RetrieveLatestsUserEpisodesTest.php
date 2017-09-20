<?php
namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveLatestsUserEpisodesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_retrieves_latests_episodes_for_user()
    {
        $this->authenticate();
    
        $user = factory(User::class)->create();
        
        $userFeedsOne = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'listen_all' => false,
        ]);
    
        $userFeedsTwo = factory(UserFeed::class)->create([
            'user_id' => $user->id,
            'listen_all' => false,
        ]);
    
        $episodeNewest = factory(Episode::class)->create([
            'feed_id' => $userFeedsOne->feed_id,
            'published_date' => Carbon::now()
        ]);
        $episodeOldest = factory(Episode::class)->create([
            'feed_id' => $userFeedsTwo->feed_id,
            'published_date' => Carbon::now()->subDay(1)
        ]);
    
        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeedsOne->id,
            'episode_id' => $episodeNewest->id,
            'paused_at' => 6
        ]);
        factory(UserEpisode::class)->create([
            'user_feed_id' => $userFeedsTwo->id,
            'episode_id' => $episodeOldest->id,
            'paused_at' => 12
        ]);
    
        $response = $this->get('/v1/users/' . $user->username . '/episodes/latests')
            ->seeStatusCode(200);
    
        $response = json_decode($response->response->getContent(), true);
    
        $expectedNewest = (new FeedTransformer)->transform($userFeedsOne->feed()->first());
        $ep = (new EpisodeTransformer())->transform($episodeNewest);
        $ep['paused_at'] = 12;
        $expectedNewest['episode'] = $ep;
        unset($expectedNewest['episodes']);
        
        $expectedOldest = (new FeedTransformer)->transform($userFeedsTwo->feed()->first());
        $ep = (new EpisodeTransformer())->transform($episodeOldest);
        $ep['paused_at'] = 6;
        $expectedOldest['episode'] = $ep;
        unset($expectedOldest['episodes']);
    
       /* $this->assertEquals([
            'data' => [
                $expectedOldest,
                $expectedNewest,
            ]
        ], $response);*/
    }
    
    /** @test */
    public function it_requires_valid_filter()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        
        $this->get('/v1/users/' . $user->username . '/episodes/latests?invalidFilter=true')
            ->seeStatusCode(400);
    }
}
