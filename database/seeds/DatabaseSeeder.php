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
                'name' => 'Nerdcast ? Jovem Nerd',
                'url' => 'https://jovemnerd.com.br/categoria/nerdcast/feed/',
                'thumbnail_30' => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/100x100bb.jpg',
                'thumbnail_600' => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/100x100bb.jpg',
                'created_at' => '2016-06-08 03:17:42',
                'updated_at' => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-10 13:30:22',
                'total_episodes' => 559
            ],
            [
                'name' => 'Braincast',
                'url' => 'http://feeds.feedburner.com/braincastmp3',
                'thumbnail_30' => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/60x60bb.jpg',
                'thumbnail_600' => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/60x60bb.jpg',
                'created_at' => '2016-06-08 03:18:33',
                'updated_at' => '2016-06-13 06:02:17',
                'last_episode_at' => '2016-06-09 20:04:38',
                'total_episodes' => 181
            ],
            [
                'name' => 'DevNaEstrada - desenvolvimento web',
                'url' => 'http://devnaestrada.com.br/feed.xml',
                'thumbnail_30' => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/60x60bb.jpg',
                'thumbnail_600' => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/60x60bb.jpg',
                'created_at' => '2016-06-08 03:16:43',
                'updated_at' => '2016-06-13 06:02:15',
                'last_episode_at' => '2016-06-10 00:00:00',
                'total_episodes' => 58
            ],
            [
                'name' => 'CodeNewbie',
                'url' => 'http://feeds.podtrac.com/q8s8ba9YtM6r',
                'thumbnail_30' => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/60x60bb.jpg',
                'thumbnail_600' => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/60x60bb.jpg',
                'created_at' => '2016-06-08 03:17:23',
                'updated_at' => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-13 04:14:07',
                'total_episodes' => 92
            ],
            [
                'name' => 'Mamilos',
                'url' => 'http://feeds.feedburner.com/mamilos',
                'thumbnail_30' => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/60x60bb.jpg',
                'thumbnail_600' => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/60x60bb.jpg',
                'created_at' => '2016-06-08 03:18:26',
                'updated_at' => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-10 20:56:04',
                'total_episodes' => 73
            ],
            [
                'name' => 'Mupoca',
                'url' => 'http://feeds.soundcloud.com/users/soundcloud:users:85493181/sounds.rss',
                'thumbnail_30' => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/30x30bb.jpg',
                'thumbnail_60' => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/60x60bb.jpg',
                'thumbnail_100' => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/60x60bb.jpg',
                'thumbnail_600' => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/60x60bb.jpg',
                'created_at' => '2016-06-08 03:18:29',
                'updated_at' => '2016-06-13 06:02:31',
                'last_episode_at' => '2016-06-02 22:59:55',
                'total_episodes' => 48
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
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0101/his-prima-eligendi.html',
                'published_date' => '2016-05-20 10:01:43',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0101/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0102/his-prima-eligendi.html',
                'published_date' => '2016-05-27 12:15:17',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0102/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 1,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0103/his-prima-eligendi.html',
                'published_date' => '2016-05-27 12:21:23',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0103/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'

            ],
            [
                'feed_id' => 1,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0104/his-prima-eligendi.html',
                'published_date' => '2016-06-03 13:20:26',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0104/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 1,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0105/his-prima-eligendi.html',
                'published_date' => '2016-06-03 13:25:14',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0105/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 1,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0106/his-prima-eligendi.html',
                'published_date' => '2016-06-10 13:30:22',
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0106/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 2,
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0201/his-prima-eligendi.html',
                'published_date' => "2016-05-06 08:21:17",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0201/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 2,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0202/his-prima-eligendi.html',
                'published_date' => "2016-05-13 03:35:42",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0202/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 2,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0203/his-prima-eligendi.html',
                'published_date' => "2016-05-19 19:15:31",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0203/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 2,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0204/his-prima-eligendi.html',
                'published_date' => "2016-05-26 23:01:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0204/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 2,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0205/his-prima-eligendi.html',
                'published_date' => "2016-06-03 02:11:04",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0205/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [

                'feed_id' => 2,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0206/his-prima-eligendi.html',
                'published_date' => "2016-06-09 20:04:38",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0206/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0301/his-prima-eligendi.html',
                'published_date' => "2016-05-06 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0301/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0302/his-prima-eligendi.html',
                'published_date' => "2016-05-13 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0302/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0303/his-prima-eligendi.html',
                'published_date' => "2016-05-20 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0303/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0304/his-prima-eligendi.html',
                'published_date' => "2016-05-27 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0304/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0305/his-prima-eligendi.html',
                'published_date' => "2016-06-03 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0305/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 3,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0306/his-prima-eligendi.html',
                'published_date' => "2016-06-10 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0306/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0401/his-prima-eligendi.html',
                'published_date' => "2016-05-09 06:03:59",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0401/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0402/his-prima-eligendi.html',
                'published_date' => "2016-05-16 04:27:11",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0402/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0403/his-prima-eligendi.html',
                'published_date' => "2016-05-23 05:39:27",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0403/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0404/his-prima-eligendi.html',
                'published_date' => "2016-05-30 07:14:15",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0404/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0405/his-prima-eligendi.html',
                'published_date' => "2016-06-06 06:49:57",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0405/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 4,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0406/his-prima-eligendi.html',
                'published_date' => "2016-06-13 04:14:07",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0406/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0501/his-prima-eligendi.html',
                'published_date' => "2016-05-14 12:41:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0501/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0502/his-prima-eligendi.html',
                'published_date' => "2016-05-20 18:38:26",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0502/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0503/his-prima-eligendi.html',
                'published_date' => "2016-05-24 16:10:16",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0503/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0504/his-prima-eligendi.html',
                'published_date' => "2016-05-27 16:37:25",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0504/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0505/his-prima-eligendi.html',
                'published_date' => "2016-06-04 13:29:24",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0505/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 5,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0506/his-prima-eligendi.html',
                'published_date' => "2016-06-10 20:56:04",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0506/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '01 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0601/his-prima-eligendi.html',
                'published_date' => "2016-03-20 19:38:05",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0601/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '02 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0602/his-prima-eligendi.html',
                'published_date' => "2016-03-31 22:14:07",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0602/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '03 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0603/his-prima-eligendi.html',
                'published_date' => "2016-04-12 04:12:54",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0603/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '04 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0604/his-prima-eligendi.html',
                'published_date' => "2016-04-28 14:37:06",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0604/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '05 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0605/his-prima-eligendi.html',
                'published_date' => "2016-05-19 20:31:20",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0605/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'feed_id' => 6,
                'title' => '06 - ' . Faker\Provider\Lorem::sentence(3),
                'link' => 'podcast.com.br/0606/his-prima-eligendi.html',
                'published_date' => "2016-06-02 22:59:55",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => 'podcast.com.br/0606/his-prima-eligendi.mp3',
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ]
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
            [
                'username' => 'bruno2546',
                'email' => 'bruno2546@brnbp.me',
                'password' => bcrypt('bruno2546'),
                'remember_token' => md5('bruno2546')
            ],
            [
                'username' => 'brnbp',
                'email' => 'brnbp@brnbp.me',
                'password' => bcrypt('brnbp'),
                'remember_token' => md5('brnbp')
            ]
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
            ],
            [
                'user_id' => 1,
                'feed_id' => 3
            ],
            [
                'user_id' => 1,
                'feed_id' => 4
            ],
            [
                'user_id' => 1,
                'feed_id' => 6
            ],
            [
                'user_id' => 2,
                'feed_id' => 2
            ],
            [
                'user_id' => 2,
                'feed_id' => 4
            ],
            [
                'user_id' => 2,
                'feed_id' => 5
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
                'episode_id' => 2,
                'hide' => 0,
                'heard' => 1,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 1,
                'episode_id' => 3,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
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
                'user_feed_id' => 1,
                'episode_id' => 5,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 1,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 3,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 4,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 5,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 2,
                'episode_id' => 6,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 4,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 5,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 3,
                'episode_id' => 6,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 5,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 6,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 5,
                'episode_id' => 3,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 4,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
                'episode_id' => 5,
                'hide' => 0,
                'heard' => 0,
                'downloaded' => 0,
                'paused_at' => 0
            ],
            [
                'user_feed_id' => 4,
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
