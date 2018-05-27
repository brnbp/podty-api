<?php

namespace Tests\Integration\UserFavoritesEpisodes;

use App\Models\Episode;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserFavoritesEpisodes extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var \App\Models\UserFeed
     */
    protected $userFeeds;

    /**
     * @var \App\Models\Episode
     */
    protected $episode;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->userFeeds = factory(UserFeed::class)->create(['user_id' => $this->user->id]);

        $this->episode = factory(Episode::class)->create([
            'feed_id' => $this->userFeeds->feed_id,
        ]);

        factory(UserEpisode::class)->create([
            'user_feed_id' => $this->userFeeds->id,
            'episode_id'   => $this->episode->id,
        ]);
    }
}
