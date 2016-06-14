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
                'id' => 1,
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
                'id' => 2,
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
                'id' => 3,
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
                'id' => 4,
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
                'id' => 5,
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
            ],
            [
                'id' => 6,
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
                'id' => 53,
                'feed_id' => 1,
                'title' => "DNE 52 - Flexibilidade no Trabalho",
                'link' => 'podcast.com.br/0106/his-prima-eligendi.html',
                'published_date' => "2016-05-06 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/262722954-devnaestrada-devnaestrada-52-flexibilidade-no-trabalho.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 54,
                'feed_id' => 1,
                'title' => "DNE 53 - Entrevista Bruno Tarmann",
                'link' => 'podcast.com.br/0101/his-prima-eligendi.html',
                'published_date' => "2016-05-13 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/263880622-devnaestrada-devnaestrada-53-entrevista-bruno-tarmann.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 55,
                'feed_id' => 1,
                'title' => "DNE 54 - Partiu Canadá com Vanhack",
                'link' => 'podcast.com.br/0102/his-prima-eligendi.html',
                'published_date' => "2016-05-20 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/264999365-devnaestrada-devnaestrada-54-partiu-canada-com-vanhack.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 56,
                'feed_id' => 1,
                'title' => "DNE 55 - Entrevista Giovanni Bassi",
                'link' => 'podcast.com.br/0103/his-prima-eligendi.html',
                'published_date' => "2016-05-27 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/266130916-devnaestrada-devnaestrada-55-entrevista-giovanni-bassi.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'

            ],
            [
                'id' => 57,
                'feed_id' => 1,
                'title' => "DNE 56 - Data Science",
                'link' => 'podcast.com.br/0104/his-prima-eligendi.html',
                'published_date' => "2016-06-03 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/267220053-devnaestrada-devnaestrada-56-data-science.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 2520,
                'feed_id' => 1,
                'title' => "DNE 57 - Entrevista Eduardo Shiota",
                'link' => 'podcast.com.br/0105/his-prima-eligendi.html',
                'published_date' => "2016-06-10 00:00:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/268414547-devnaestrada-devnaestrada-57-entrevista-eduardo-shiota.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 144,
                'feed_id' => 2,
                'title' => "Ep. 87 - Vets Who Code (Jerome Hardaway)",
                'link' => 'podcast.com.br/0201/his-prima-eligendi.html',
                'published_date' => "2016-05-09 06:03:59",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/57302704b654f90629157758/1462773561201/Jerome_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 145,
                'feed_id' => 2,
                'title' => "Ep. 88 - CodeNewbie Apprentice (Sharon Siegel)",
                'link' => 'podcast.com.br/0202/his-prima-eligendi.html',
                'published_date' => "2016-05-16 04:27:11",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/57394a0b2fe131630fce04aa/1463372367610/Sharon+Session+6_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 146,
                'feed_id' => 2,
                'title' => "Ep. 89 - Mobile Developer (Kaya Thomas)",
                'link' => 'podcast.com.br/0203/his-prima-eligendi.html',
                'published_date' => "2016-05-23 05:39:27",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/5742963a356fb0ac05bbfe2c/1463981674487/KayaThomasc_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 147,
                'feed_id' => 2,
                'title' => "Ep. 90 - Creating EmberJS - Part I (Yehuda Katz)",
                'link' => 'podcast.com.br/0204/his-prima-eligendi.html',
                'published_date' => "2016-05-30 07:14:15",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/574be63837013bafc3a8445a/1464591988495/Yehuda_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 148,
                'feed_id' => 2,
                'title' => "Ep. 91 - Creating EmberJS - Part II (Yehuda Katz)",
                'link' => 'podcast.com.br/0205/his-prima-eligendi.html',
                'published_date' => "2016-06-06 06:49:57",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/57551b72746fb93a8a59519b/1465195441892/Yehuda_part_2_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 5418,
                'feed_id' => 2,
                'title' => "Ep. 92 - Afghan Women Coding (Fereshteh Forough)",
                'link' => 'podcast.com.br/0206/his-prima-eligendi.html',
                'published_date' => "2016-06-13 04:14:07",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://dts.podtrac.com/redirect.mp3/static1.squarespace.com/static/5161ac76e4b0d5cb924e7ed5/t/575e315320c647c0a00ab80c/1465790879480/Fereshteh_mixdown.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 702,
                'feed_id' => 3,
                'title' => "Nerdcast 517 ? Monstros do cinema",
                'link' => 'podcast.com.br/0301/his-prima-eligendi.html',
                'published_date' => "2016-05-20 13:11:17",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/150423/0/nc517.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 703,
                'feed_id' => 3,
                'title' => "Nerdcast Empreendedor 17 ? Empreendedores bilionários",
                'link' => 'podcast.com.br/0302/his-prima-eligendi.html',
                'published_date' => "2016-05-27 12:15:17",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/151183/0/exe17.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 704,
                'feed_id' => 3,
                'title' => "Nerdcast 518 ? Rei Artur: História e mito",
                'link' => 'podcast.com.br/0303/his-prima-eligendi.html',
                'published_date' => "2016-05-27 12:21:23",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/151170/0/nc518.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 705,
                'feed_id' => 3,
                'title' => "Nerdtech 04 ? Plataformas e Arquitetura de Sistemas",
                'link' => 'podcast.com.br/0304/his-prima-eligendi.html',
                'published_date' => "2016-06-03 13:20:26",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/152300/0/nerdtech_04.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 706,
                'feed_id' => 3,
                'title' => "Nerdcast 519 ? Nerd Rico, Nerd Pobre 3",
                'link' => 'podcast.com.br/0305/his-prima-eligendi.html',
                'published_date' => "2016-06-03 13:25:14",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/151835/0/nc519.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 2521,
                'feed_id' => 3,
                'title' => "Nerdcast 520 ? Especial Dia dos Namorados 2016",
                'link' => 'podcast.com.br/0306/his-prima-eligendi.html',
                'published_date' => "2016-06-10 13:30:22",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "https://jovemnerd.com.br/podpress_trac/feed/152595/0/nerdcast520diadosnamorados.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 774,
                'feed_id' => 4,
                'title' => "#68 - Rafael Braga E Homofobia No Futebol",
                'link' => 'podcast.com.br/0401/his-prima-eligendi.html',
                'published_date' => "2016-05-14 12:41:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/264085939-mamilospod-68-rafael-braga-e-homofobia-no-futebol.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 775,
                'feed_id' => 4,
                'title' => "#69 - Conversando Sobre Pornô no Banheiro Feminino",
                'link' => 'podcast.com.br/0402/his-prima-eligendi.html',
                'published_date' => "2016-05-20 18:38:26",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/265099584-mamilospod-69-conversando-sobre-porno-no-banheiro-feminino.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 776,
                'feed_id' => 4,
                'title' => "Extra - Entrevista com Rico Dalasam",
                'link' => 'podcast.com.br/0403/his-prima-eligendi.html',
                'published_date' => "2016-05-24 16:10:16",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/265698131-mamilospod-extra-entrevista-com-rico-dalasam.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 777,
                'feed_id' => 4,
                'title' => "#70 - Adoção",
                'link' => 'podcast.com.br/0404/his-prima-eligendi.html',
                'published_date' => "2016-05-27 16:37:25"   ,
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/266209439-mamilospod-70-adocao.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 778,
                'feed_id' => 4,
                'title' => "#71 - Cultura Do Estupro",
                'link' => 'podcast.com.br/0405/his-prima-eligendi.html',
                'published_date' => "2016-06-04 13:29:24",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/267516784-mamilospod-71-cultura-do-estupro.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 2600,
                'feed_id' => 4,
                'title' => "#72 - Muhammad Ali e Trabalho escravo",
                'link' => 'podcast.com.br/0406/his-prima-eligendi.html',
                'published_date' => "2016-06-10 20:56:04",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/268515439-mamilospod-72-muhammad-ali-e-trabalho-escravo.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 821,
                'feed_id' => 5,
                'title' => "#043 - Inevitáveis bugs",
                'link' => 'podcast.com.br/0501/his-prima-eligendi.html',
                'published_date' => "2016-03-20 19:38:05",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/253661633-mupoca-043-inevitaveis-bugs.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 822,
                'feed_id' => 5,
                'title' => "#044 - Inteligência artificial: deu ruim (ou parte 2)",
                'link' => 'podcast.com.br/0502/his-prima-eligendi.html',
                'published_date' => "2016-03-31 22:14:07",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/256647093-mupoca-044-inteligencia-artificial-deu-ruim-ou-parte-2.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 823,
                'feed_id' => 5,
                'title' => "#045 - Brasil das metáforas",
                'link' => 'podcast.com.br/0503/his-prima-eligendi.html',
                'published_date' => "2016-04-12 04:12:54",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/258570524-mupoca-045-brasil-das-metaforas.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 824,
                'feed_id' => 5,
                'title' => "#046 ? God save the Brazilian king!",
                'link' => 'podcast.com.br/0504/his-prima-eligendi.html',
                'published_date' => "2016-04-28 14:37:06",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/261333660-mupoca-046-god-save-the-brazilian-king.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 825,
                'feed_id' => 5,
                'title' => "#047 - Cultura underdog",
                'link' => 'podcast.com.br/0505/his-prima-eligendi.html',
                'published_date' => "2016-05-19 20:31:20",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/264953607-mupoca-047-cultura-underdog.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 826,
                'feed_id' => 5,
                'title' => "#048 - Formação acadêmica do futuro",
                'link' => 'podcast.com.br/0506/his-prima-eligendi.html',
                'published_date' => "2016-06-02 22:59:55",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/267185335-mupoca-048-formacao-academica-do-futuro.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 1002,
                'feed_id' => 6,
                'title' => "#190. Voce? Esta? Sendo Substitui?do Por Um Robo",
                'link' => 'podcast.com.br/0601/his-prima-eligendi.html',
                'published_date' => "2016-05-06 08:21:17",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/262748223-brains9-190-voce-esta-sendo-substituido-por-um-robo.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 1003,
                'feed_id' => 6,
                'title' => "#191. Por que gostamos de terror?",
                'link' => 'podcast.com.br/0602/his-prima-eligendi.html',
                'published_date' => "2016-05-13 03:35:42",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/263883784-brains9-191-por-que-gostamos-de-terror.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 1004,
                'feed_id' => 6,
                'title' => "#192. A Arte do Feedback",
                'link' => 'podcast.com.br/0603/his-prima-eligendi.html',
                'published_date' => "2016-05-19 19:15:31",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/264941990-brains9-192-a-arte-do-feedback.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 1005,
                'feed_id' => 6,
                'title' => "#193. Por que a Cultura importa?",
                'link' => 'podcast.com.br/0604/his-prima-eligendi.html',
                'published_date' => "2016-05-26 23:01:00",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/266105007-brains9-193-por-que-a-cultura-importa.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 1006,
                'feed_id' => 6,
                'title' => "#194. O direito à desconexa?o",
                'link' => 'podcast.com.br/0605/his-prima-eligendi.html',
                'published_date' => "2016-06-03 02:11:04",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/267207212-brains9-194-o-direito-a-desconexao.mp3",
                'media_length' => Faker\Provider\Lorem::numberBetween(34534, 78678),
                'media_type' => 'audio/mpeg'
            ],
            [
                'id' => 2296,
                'feed_id' => 6,
                'title' => "#195. O Mercado do Futebol",
                'link' => 'podcast.com.br/0606/his-prima-eligendi.html',
                'published_date' => "2016-06-09 20:04:38",
                'content' => Faker\Provider\Lorem::sentence(17),
                'media_url' => "http://feeds.soundcloud.com/stream/268348614-brains9-195-o-mercado-do-futebol.mp3",
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

    public function seedUserEpisodes()
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
