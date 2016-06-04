<?php
namespace App\Models;

use App\Jobs\RegisterEpisodesFeed;
use App\Services\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Feed
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Feed extends Model
{
    use DispatchesJobs;

    /** @var array $content */
    private $content = [];

    /** @var bool $has_content */
    public $has_content = false;

    /** @var string $table nome da tabela referente a model */
    protected $table = 'feeds';

    protected $fillable = [
        'url', 'name', 'thumbnail_30', 'thumbnail_60', 'thumbnail_100', 'thumbnail_600'
    ];

    /**
     * Define relação com a model Episodes, sendo que Feed possui varios episodios
     * ligados a ele
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany('App\Models\Episode');
    }

    public function getContent()
    {
        $content = array_filter($this->content);

        return empty($content) ? $content : reset($content);
    }

    public function storage($feeds)
    {
        foreach($feeds as $feed) {

            $table_content = [
                'name' => $feed['collectionName'],
                'thumbnail_30' => $feed['artworkUrl30'],
                'thumbnail_60' => $feed['artworkUrl60'],
                'thumbnail_100' => $feed['artworkUrl100'],
                'thumbnail_600' => $feed['artworkUrl600']
            ];

            $row_content = $this->upsert($table_content, [
                'url' => $feed['feedUrl']
            ], true);

            $this->setContent($row_content->getAttributes());
        }
    }

    /**
     * Update or Create content
     * @param array $content array of contents being ['field' => 'value']
     * @param array $filter array of filters being ['field' => 'value']
     * @param bool $insert sets for insert if not exists, default is false
     *
     * @return bool|int
     */
    private function upsert(array $content, array $filter, $insert = false)
    {
        if ($insert) {
            return self::updateOrCreate($filter, $content);
        }

        return self::update($content, $filter);
    }

    public function findLikeName($name)
    {
        $feed = self::where('name', 'LIKE', "%$name%")->take(5)->get();

        $this->setContent($feed->toArray());
    }

    public function checkExists($name)
    {
        $this->findLikeName($name);
        return $this->has_content;
    }

    private function setContent(array $content)
    {
        $this->content[] = $content;
        $this->has_content = count($content) ? true : false;
    }

    public function getUrlById($id)
    {
        $feed = self::where('id', $id)->get();

        $content = $feed->toArray();

        return reset($content)['url'];
    }

    public function sendToQueueUpdate(array $feeds)
    {
        foreach ($feeds as $feed) {
            $this->dispatch(new RegisterEpisodesFeed($feed));
        }
    }

    /**
     * Busca pelos feeds que recentemente publicaram novos episodios
     * @param integer $limit limite de quantidade de retorno, por padrao, 10
     */
    public function getLatestsUpdated($limit = 10)
    {
        return self::take($limit)
            ->orderBy('last_episode_at', 'DESC')
            ->get();
    }

    /**
     * Atualiza em feeds a data do ultimo episodio lançado
     */
    public function updateLastEpisodeAt()
    {
        $Filter = new Filter();
        $Filter->setLimit(10);

        $Episodes = ((new Episode())->getLatests($Filter));
        $Episodes
            ->unique('feed_id')
            ->map(function($episode){
                self::where('id', $episode->feed_id)
                    ->update([
                        'last_episode_at' => $episode->published_date
                    ]);
            });
    }

    /**
     * Update on Feed's table the total of episodes
     * @param integer $feed_id id of feed
     */
    public function updateTotalEpisodes($feedId)
    {
        self::where('id', $feedId)
            ->update([
                'total_episodes' => (new Episode())->getTotalEpisodes($feedId)
            ]);
    }
}
