<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /** @var array $content */
    private $content = [];

    /** @var bool $has_content */
    public $has_content = false;

    protected $table = 'feeds';

    protected $fillable = [
        'url', 'name', 'thumbnail_30', 'thumbnail_60', 'thumbnail_100', 'thumbnail_600'
    ];

    public function getContent()
    {
        $content = array_filter($this->content);

        if (empty($content)) {
            return false;
        }
        $arr = reset($content);
        return is_array(current($arr)) ? current($arr) : $arr;
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
    public function upsert(array $content, array $filter, bool $insert = false)
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

}
