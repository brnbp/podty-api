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
                'episode_id' => 55,
                'hide' => 0,
                'heard' => 1,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 56,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 57,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 2520,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 146,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 147,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 148,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 5418,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 705,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 706,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 2521,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 778,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 2600,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 5,
                'episode_id' => 2296,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 6,
                'episode_id' => 5418,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 7,
                'episode_id' => 2600,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 8,
                'episode_id' => 826,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ]
        ];

        foreach ($episodes as $episode) {
            DB::table('user_episodes')->insert($episode);
        }
    }
}
