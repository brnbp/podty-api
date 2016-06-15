<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: brnbp
 * Date: 6/14/16
 * Time: 10:22 PM
 */
class UserFeedsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_feeds = [
            [
                'id' => 1,
                'user_id' => 1,
                'feed_id' => 1
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'feed_id' => 2
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'feed_id' => 3
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'feed_id' => 4
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'feed_id' => 6
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'feed_id' => 2
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'feed_id' => 4
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'feed_id' => 5
            ]
        ];

        foreach ($user_feeds as $user_feed) {
            DB::table('user_feeds')->insert($user_feed);
        }
    }
}
