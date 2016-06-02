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
        $feeds = [
            [
                'name' => 'nerdcast',
                'url' => 'http://www.podcast.com.br/feed',
                'thumbnail_30' => 'www.podcast.com.br/30/cover_feed.jpg',
                'thumbnail_60' => 'www.podcast.com.br/60/cover_feed.jpg',
                'thumbnail_100' => 'www.podcast.com.br/100/cover_feed.jpg',
                'thumbnail_600' => 'www.podcast.com.br/600/cover_feed.jpg',
                'created_at' => '2016-05-20 16:30:01',
                'updated_at' => '2016-05-25 19:10:00',
                'total_episodes' => 550
            ],
            [
                'name' => 'braincast',
                'url' => 'http://www.podcast.com.br/feed2',
                'thumbnail_30' => 'www.podcast.com.br/30/cover_feed.jpg',
                'thumbnail_60' => 'www.podcast.com.br/60/cover_feed.jpg',
                'thumbnail_100' => 'www.podcast.com.br/100/cover_feed.jpg',
                'thumbnail_600' => 'www.podcast.com.br/600/cover_feed.jpg',
                'created_at' => '2016-04-20 16:30:01',
                'updated_at' => '2016-05-25 19:10:00',
                'total_episodes' => 190
            ],
            [
                'name' => 'devnaestrada',
                'url' => 'http://www.podcast.com.br/feed3',
                'thumbnail_30' => 'www.podcast.com.br/30/cover_feed.jpg',
                'thumbnail_60' => 'www.podcast.com.br/60/cover_feed.jpg',
                'thumbnail_100' => 'www.podcast.com.br/100/cover_feed.jpg',
                'thumbnail_600' => 'www.podcast.com.br/600/cover_feed.jpg',
                'created_at' => '2016-05-30 16:30:01',
                'updated_at' => '2016-05-30 19:10:00',
                'total_episodes' => 55
            ]
        ];

        foreach ($feeds as $feed) {
            DB::table('feeds')->insert($feed);
        }
    }

    public function seedEpisodes()
    {
        $episodes = [
            [
                'feed_id' => 1,
                'title' => '01 - his prima eligendi',
                'link' => 'podcast.com.br/0101/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'consequat elit nisi non magna. Aliquam erat volutpat. Morbi quis tincidunt risus, nec sagittis elit. Suspendisse malesuada hendrerit',
                'media_url' => 'podcast.com.br/0101/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '02 - his prima eligendi',
                'link' => 'podcast.com.br/0102/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Vivamus nec tincidunt neque. Mauris ornare diam nec urna dapibus, quis finibus nisi condimentum. Integer lacinia ac justo id iaculis.',
                'media_url' => 'podcast.com.br/0102/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '03 - his prima eligendi',
                'link' => 'podcast.com.br/0103/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Integer fringilla erat risus, et facilisis dui vehicula vitae. Cras tincidunt rutrum magna. Aenean convallis sem ut quam lobortis, sed facilisis lectus commodo.',
                'media_url' => 'podcast.com.br/0103/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '04 - his prima eligendi',
                'link' => 'podcast.com.br/0104/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Nulla eget mauris id lacus tristique efficitur ut ac sem. Duis vulputate eu neque at pretium. Pellentesque vestibulum mollis massa id imperdiet.',
                'media_url' => 'podcast.com.br/0104/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '05 - his prima eligendi',
                'link' => 'podcast.com.br/0105/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Maecenas sem nisi, venenatis eget convallis id, mattis sed dolor. Sed viverra ante id nisl consequat aliquet. Morbi commodo vel ligula non viverra.',
                'media_url' => 'podcast.com.br/0105/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '06 - his prima eligendi',
                'link' => 'podcast.com.br/0106/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Quisque sit amet dui dui. Integer commodo, nisl vel dignissim scelerisque, augue mi dictum nunc, vitae condimentum mauris nibh volutpat diam.',
                'media_url' => 'podcast.com.br/0106/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 2,
                'title' => '01 - his prima eligendi',
                'link' => 'podcast.com.br/0201/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Donec semper tempor est, in vehicula tellus. Curabitur et eros ut mi pulvinar euismod quis ut nisi. Aliquam erat volutpat.',
                'media_url' => 'podcast.com.br/0201/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 2,
                'title' => '02 - his prima eligendi',
                'link' => 'podcast.com.br/0202/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Curabitur ut massa sit amet ante consequat tincidunt quis non dui. Aliquam vitae scelerisque sem, eu blandit purus.',
                'media_url' => 'podcast.com.br/0202/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '07 - his prima eligendi',
                'link' => 'podcast.com.br/0107/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Fusce ante turpis, laoreet eu consectetur vestibulum, commodo nec nulla. Nulla tincidunt lectus vitae mauris laoreet, ultricies convallis eros pulvinar.',
                'media_url' => 'podcast.com.br/0107/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '01 - his prima eligendi',
                'link' => 'podcast.com.br/0301/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Nunc malesuada tempus lectus ut euismod. Donec efficitur lacus condimentum lacus dignissim tempus. Cras iaculis viverra felis et tempor.',
                'media_url' => 'podcast.com.br/0301/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 2,
                'title' => '03 - his prima eligendi',
                'link' => 'podcast.com.br/0203/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Aenean convallis sem ut quam lobortis, sed facilisis lectus commodo. Mauris dictum quam et est posuere venenatis. Mauris interdum libero imperdiet, porttitor nibh vitae, feugiat nulla.',
                'media_url' => 'podcast.com.br/0203/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '02 - his prima eligendi',
                'link' => 'podcast.com.br/0302/his-prima-eligendi.html',
                'published_date' => '0000-00-00 00:00:00',
                'content' => 'Praesent id urna eu est facilisis tempor. Praesent bibendum efficitur nisi, ac scelerisque augue molestie eu. Nullam viverra nisi sed tortor molestie efficitur.',
                'media_url' => 'podcast.com.br/0302/his-prima-eligendi.mp3',
                'media_length' => '3423',
                'media_type' => 'audio/mpeg'
            ],
        ];

        foreach ($episodes as $episode) {
            DB::table('episodes')->insert($episode);
        }
    }

    public function seedJobs()
    {
        $jobs = [
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload one']]),
                'attempts' => 2,
                'reserved' => 1,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload two']]),
                'attempts' => 1,
                'reserved' => 1,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload three']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload four']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload five']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload six']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload seven']]),
                'attempts' => 0,
                'reserved' => 0,
            ]
        ];

        foreach ($jobs as $job) {
            DB::table('jobs')->insert($job);
        }
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
        $user_feeds = [
            [
                'user_id' => 1,
                'feed_id' => 1
            ],
            [
                'user_id' => 1,
                'feed_id' => 2
            ]
        ];

        foreach ($user_feeds as $user_feed) {
            DB::table('user_feeds')->insert($user_feed);
        }
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
                'episode_id' => 4,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 1,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 6,
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
