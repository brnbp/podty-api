<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFeed();
        $this->seedEpisodes();
        $this->seedJobs();
        $this->seedUsers();
        $this->seedUserFeeds();
        $this->seedUserEpisodes();
    }

    public function seedFeed()
    {
        DB::table('feeds')->insert([
            'name' => 'nerdcast',
            'url' => 'http://www.podcast.com.br/feed',
            'thumbnail_30' => 'www.podcast.com.br/30/cover_feed.jpg',
            'thumbnail_60' => 'www.podcast.com.br/60/cover_feed.jpg',
            'thumbnail_100' => 'www.podcast.com.br/100/cover_feed.jpg',
            'thumbnail_600' => 'www.podcast.com.br/600/cover_feed.jpg'
        ]);
    }

    public function seedEpisodes()
    {
        $episodes = [
            [
                'feed_id' => 1,
                'title' => '01 - his prima eligendi',
                'link' => 'podcast.com.br/01/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/01/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '02 - his prima eligendi',
                'link' => 'podcast.com.br/02/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/02/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '03 - his prima eligendi',
                'link' => 'podcast.com.br/03/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/03/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '04 - his prima eligendi',
                'link' => 'podcast.com.br/04/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/04/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '05 - his prima eligendi',
                'link' => 'podcast.com.br/05/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/05/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '06 - his prima eligendi',
                'link' => 'podcast.com.br/06/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/06/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '07 - his prima eligendi',
                'link' => 'podcast.com.br/07/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'empty',
                'media_url' => 'podcast.com.br/07/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ]
        ];

        foreach ($episodes as $episode) {
            DB::table('episodes')->insert($episode);
        }
    }

    public function seedJobs()
    {
        DB::table('jobs')->insert([
            'queue' => 'feeds',
            'payload' => 'payload',
            'attempts' => 2,
            'reserved' => 1,
            'reserved_at' => 16213,
            'available_at' => 15132,
            'created_at' => 14324
        ]);
    }

    public function seedUsers()
    {
        DB::table('users')->insert([
            'username' => 'bruno2546',
            'email' => 'bruno2546@brnbp.me',
            'password' => bcrypt('bruno2546'),
            'remember_token' => md5('bruno2546')
        ]);
    }

    public function seedUserFeeds()
    {
        DB::table('user_feeds')->insert([
            'user_id' => 1,
            'feed_id' => 1
        ]);
    }

    public function seedUserEpisodes()
    {
        $episodes = [
            [
                'user_feed_id' => 1,
                'episode_id' => 1,
                'hide' => 0,
                'heard' => 1,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 2,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 3,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 3,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 4,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 5,
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
