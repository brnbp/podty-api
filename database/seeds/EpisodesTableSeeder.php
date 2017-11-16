<?php
use Illuminate\Database\Seeder;

class EpisodesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getData() as $episode) {
            DB::table('episodes')->insert($episode);
        }
    }

    private function getData()
    {
        return [
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
                'title' => "Nerdcast Empreendedor 17 ? Empreendedores bilion�rios",
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
                'title' => "Nerdcast 518 ? Rei Artur: Hist�ria e mito",
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
                'title' => "#69 - Conversando Sobre Porn� no Banheiro Feminino",
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
                'title' => "#70 - Ado��o",
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
                'title' => "#043 - Inevit�veis bugs",
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
                'title' => "#044 - Intelig�ncia artificial: deu ruim (ou parte 2)",
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
                'title' => "#045 - Brasil das met�foras",
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
                'title' => "#048 - Forma��o acad�mica do futuro",
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
                'title' => "#194. O direito � desconexa?o",
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
    }
}
