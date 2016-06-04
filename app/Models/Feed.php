<?php

namespace App\Models;

use App\Jobs\RegisterEpisodesFeed;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Feed extends Model
{
    use DispatchesJobs;

    /** @var array $content */
    private $content = [];

    /** @var bool $has_content */
    public $has_content = false;

    protected $table = 'feeds';

    protected $fillable = [
        'url', 'name', 'thumbnail_30', 'thumbnail_60', 'thumbnail_100', 'thumbnail_600'
    ];

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
    private function upsert(array $content, array $filter, bool $insert = false)
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

    public function getLatestsUpdated()
    {
        return self::take(10)
            ->orderBy('last_episode_at', 'DESC')
            ->get();
    }

    /**
     * Atualiza em feeds a data do ultimo episodio lançado
     * @param $feedId
     * @param $publishedDate
     */
    public function updateLastEpisodeAt($feedId, $publishedDate)
    {
        self::where('id', $feedId)
            ->update([
                'last_episode_at' => $publishedDate
            ]);
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
