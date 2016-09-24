<?php
namespace App\Models;

use App\EpisodeEntity;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use App\Services\Parser\XML;
use App\Transform\XMLTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Episode
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Episode extends Model
{
    protected $fillable = [
        'feed_id',
        'title',
        'published_date',
        'summary',
        'content',
        'image',
        'duration',
        'link',
        'media_length',
        'media_type',
        'media_url'
    ];

    /** @var array $hidden The attributes that should be hidden for arrays. */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Define relação com a model Feeds, sendo que Episode pertence a um feed
     */
    public function feed()
    {
        $this->belongsTo(Feed::class);
    }

    /**
     * Busca pelo xml com episodios a partir do id do podcast e de sua url de feed
     * @param integer $feed_id id do feed
     * @param string $feed_url url do feed
     * @return bool
     */
    public function storage($feed_id, $feed_url)
    {
        $content = (new XML($feed_url))
            ->retrieve();

        if ($content === false) {
            return false;
        }

        $content = (new XMLTransformer)->transform($content);

        $this->insert($feed_id, $content);
        (new FeedRepository())->updateTotalEpisodes($feed_id);

        return true;
    }

    /**
     * Armazena os episodios no banco
     * @param integer $feedId id do feed
     * @param array $episodes array de episodios
     */
    private function insert($feedId, array $episodes)
    {
        $episodes = array_reverse($episodes);

        array_walk($episodes, function($episode) use($feedId) {
            (new EpisodesRepository)->save((new EpisodeEntity)
                ->setFeedId($feedId)
                ->setTitle($episode['title'])
                ->setLink($episode['link'])
                ->setPublishedDate($episode['published_date'])
                ->setSummary($episode['summary'])
                ->setDuration($episode['duration'])
                ->setImage($episode['image'])
                ->setContent($episode['content'])
                ->setMediaUrl($episode['media_url'])
                ->setMediaLength($episode['media_length'])
                ->setMediaType($episode['media_type']));
        });
    }

    /**
     * Valida se os campos de media existem, senao cria valores padr�o
     * @param $attributes
     * @return mixed
     */
    private function validateMediaFields(&$attributes)
    {
        if (!is_array($attributes)) {
            return false;
        }

        if (!key_exists('url', $attributes)) {
            return false;
        }

        if (!$this->validateMp3($attributes['url'])) {
            return false;
        }

        if (!key_exists('type', $attributes)) {
            $attributes['type'] = 'audio/mp3';
        }

        if (!key_exists('length', $attributes)) {
            $attributes['length'] = 0;
        }
        return $attributes;
    }

    private function validateMp3(&$url)
    {
        if (substr($url, -4, 1) != '.') {
            $url = preg_replace('/\?.*/', '', $url);
            if (substr($url, -4, 1) != '.') {
                return false;
            }
        }

        return $url;
    }

    /**
     * Valida se existe a chave no array
     * caso nao exista, retorna string vazia
     * caso exista, retorna o valor da chave
     * @param array $arr
     * @param string $key
     * @return array|string
     */
    private function getDefault($arr, $key)
    {
        if (isset($arr[$key])) {
            return $arr[$key];
        }

        return '';
    }
}
