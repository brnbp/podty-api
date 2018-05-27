<?php

use Illuminate\Database\Seeder;

class UserEpisodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $episodes = [
            [
                'user_feed_id' => 1,
                'episode_id'   => 55,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 1,
                'episode_id'   => 56,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 1,
                'episode_id'   => 57,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 1,
                'episode_id'   => 2520,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 2,
                'episode_id'   => 146,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 2,
                'episode_id'   => 147,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 2,
                'episode_id'   => 148,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 2,
                'episode_id'   => 5418,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 3,
                'episode_id'   => 705,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 3,
                'episode_id'   => 706,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 3,
                'episode_id'   => 2521,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 4,
                'episode_id'   => 778,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 4,
                'episode_id'   => 2600,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 5,
                'episode_id'   => 2296,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 6,
                'episode_id'   => 5418,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 7,
                'episode_id'   => 2600,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
            [
                'user_feed_id' => 8,
                'episode_id'   => 826,
                'paused_at'    => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
        ];

        foreach ($episodes as $episode) {
            DB::table('user_episodes')->insert($episode);
        }
    }
}
