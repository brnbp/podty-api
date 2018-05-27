<?php

use Illuminate\Database\Seeder;

class FeedsTableSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getData() as $feed) {
            DB::table('feeds')->insert($feed);
        }
    }

    private function getData()
    {
        return [
            [
                'id'              => 1,
                'name'            => 'DevNaEstrada - desenvolvimento web',
                'url'             => 'http://devnaestrada.com.br/feed.xml',
                'thumbnail_30'    => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is5.mzstatic.com/image/thumb/Music5/v4/18/1d/65/181d655f-9161-8a4f-65e4-75ec9587b709/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:16:43',
                'updated_at'      => '2016-06-13 06:02:15',
                'last_episode_at' => '2016-06-10 00:00:00',
                'total_episodes'  => 58,
            ],
            [
                'id'              => 2,
                'name'            => 'CodeNewbie',
                'url'             => 'http://feeds.podtrac.com/q8s8ba9YtM6r',
                'thumbnail_30'    => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is1.mzstatic.com/image/thumb/Music5/v4/dd/4f/96/dd4f9671-eb88-655f-3b3c-495552912e52/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:17:23',
                'updated_at'      => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-13 04:14:07',
                'total_episodes'  => 92,
            ],
            [
                'id'              => 3,
                'name'            => 'Nerdcast ? Jovem Nerd',
                'url'             => 'https://jovemnerd.com.br/categoria/nerdcast/feed/',
                'thumbnail_30'    => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is4.mzstatic.com/image/thumb/Music/v4/53/c4/c2/53c4c2b6-60f4-96b7-42d7-f8068b8b4323/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:17:42',
                'updated_at'      => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-10 13:30:22',
                'total_episodes'  => 559,
            ],
            [
                'id'              => 4,
                'name'            => 'Mamilos',
                'url'             => 'http://feeds.feedburner.com/mamilos',
                'thumbnail_30'    => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is3.mzstatic.com/image/thumb/Music69/v4/f4/e4/24/f4e424c7-0e34-7e38-4440-9beb8f6b975b/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:18:26',
                'updated_at'      => '2016-06-13 06:02:43',
                'last_episode_at' => '2016-06-10 20:56:04',
                'total_episodes'  => 73,
            ],
            [
                'id'              => 5,
                'name'            => 'Mupoca',
                'url'             => 'http://feeds.soundcloud.com/users/soundcloud:users:85493181/sounds.rss',
                'thumbnail_30'    => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is4.mzstatic.com/image/thumb/Music3/v4/8a/57/52/8a5752f9-1c4e-bd82-917d-4d4b7d340ee4/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:18:29',
                'updated_at'      => '2016-06-13 06:02:31',
                'last_episode_at' => '2016-06-02 22:59:55',
                'total_episodes'  => 48,
            ],
            [
                'id'              => 6,
                'name'            => 'Braincast',
                'url'             => 'http://feeds.feedburner.com/braincastmp3',
                'thumbnail_30'    => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/30x30bb.jpg',
                'thumbnail_60'    => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/60x60bb.jpg',
                'thumbnail_100'   => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/100x100bb.jpg',
                'thumbnail_600'   => 'http://is2.mzstatic.com/image/thumb/Music49/v4/db/ac/76/dbac7679-d76d-9283-7d29-9d1a40f923b1/source/600x600bb.jpg',
                'created_at'      => '2016-06-08 03:18:33',
                'updated_at'      => '2016-06-13 06:02:17',
                'last_episode_at' => '2016-06-09 20:04:38',
                'total_episodes'  => 181,
            ],
        ];
    }
}
