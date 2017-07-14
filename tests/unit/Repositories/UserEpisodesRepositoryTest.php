<?php

use App\Repositories\UserEpisodesRepository;
use App\Repositories\UserFeedsRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserEpisodesRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_retrieves_listening_episodes_for_given_user()
    {
        $episodes = factory(\App\Models\Episode::class)->times(6)->create();
    
        $user = factory(\App\Models\User::class)->create();
    
        $episodes->each(function($episode) use ($user) {
            $userFeed = UserFeedsRepository::create($episode->feed_id, $user);
            if ($episode->id <= 2) return;
            UserEpisodesRepository::markAsPaused($userFeed->id, $episode->id, random_int(100, 100000));
        });
        
        $repository = new \App\Repositories\UserEpisodesRepository();
        
        $episodes = $repository->listening($user->username);
        $this->assertCount(4, $episodes);
    }
}
