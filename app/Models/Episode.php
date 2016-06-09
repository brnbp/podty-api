<?php
namespace App\Models;

use App\EpisodeEntity;
use App\Jobs\RegisterEpisodesFeed;
use App\Services\Filter;
use App\Services\Parser\XML;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PhpSpec\Exception\Fracture\PropertyNotFoundException;

/**
 * Class Episode
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Episode extends Model
{
    /** @var array $hidden The attributes that should be hidden for arrays. */
    protected $hidden = ['created_at', 'updated_at'];

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

        $this->insert([
            'feed_id' => $feed_id,
            'episodes' => $content['channel']['item']
        ]);

        (new Feed())->updateTotalEpisodes($feed_id);

        return true;
    }

    /**
     * Armazena os episodios no branco de dados
     * @param array $content array de episodios para salvar no banco
     */
    private function insert(array $content)
    {
        foreach (array_reverse($content['episodes']) as $episode) {
            $this->validateMediaFields($episode['enclosure']['@attributes']);

            (new EpisodeEntity())
                ->setFeedId($content['feed_id'])
                ->setTitle($episode['title'])
                ->setLink($this->getDefault($episode, 'link'))
                ->setPublishedDate($this->getDefault($episode, 'pubDate'))
                ->setContent($this->getDefault($episode, 'description'))
                ->setMediaUrl($episode['enclosure']['@attributes']['url'] ?: '')
                ->setMediaLength($episode['enclosure']['@attributes']['length'] ?: '')
                ->setMediaType($episode['enclosure']['@attributes']['type'] ?: '')
                ->persist();
        }
    }

    /**
     * @param integer $feed_id id of feed
     */
    public function getTotalEpisodes($feed_id)
    {
        return self::where('feed_id', $feed_id)->count();
    }

    /**
     * Busca por episodios a partir de campo na tabela episodes
     * @param integer $id id do podcast
     * @return mixed
     */
    public function getByFeedId($feedId, Filter $filter)
    {
        $Feed = Feed::find($feedId);

        if (is_null($Feed )) {
            return [];
        }

        return $Feed
            ->episodes()
            ->skip($filter->offset)
            ->take($filter->limit)
            ->orderBy('id', $filter->order)
            ->get()
            ->toArray();
    }

    /**
     * Utilizado em Cron
     * Coloca na fila todos os feeds existentes para busca de novos episodios
     */
    public function getNew()
    {
        (new Feed())->sendToQueueUpdate(Feed::all(['url', 'id'])->toArray());
    }

    /**
     * Valida se os campos de media existem, senao cria valores padrão
     * @param $attributes
     * @return mixed
     */
    private function validateMediaFields(&$attributes)
    {
        if (!key_exists('url', $attributes)) {
            $attributes['url'] = 'empty';
        }

        if (!key_exists('type', $attributes)) {
            $attributes['type'] = 'audio/mpeg';
        }

        if (!key_exists('length', $attributes)) {
            $attributes['length'] = 0;
        }
        return $attributes;
    }

    /**
     * Verifica se existe episodio a partir de mediaUrl property
     * @param string $mediaUrl opcional, caso nao tenha sido setado na classe ainda
     * @return boolean retorna true se existe e falso caso nao exista
     *
     * @throws PropertyNotFoundException
     * caso nao seja informado o parametro e a propriedade nao tenha sido definida ainda
     */
    public function exists($mediaUrl = null)
    {
        if ($mediaUrl) {
            $this->media_url = $mediaUrl;
        }

        if (!$this->media_url) {
            throw new PropertyNotFoundException('property media_url not defined', $this, 'media_url');
        }
        $ret = self::where('media_url', $this->media_url)->select('id')->get();
        return !$ret->isEmpty();
    }

    /**
     * Busca pelos ultimos episodios publicados pelos podcasts
     * @param Filter $filter
     */
    public function getLatests(Filter $filter)
    {
        return self::take($filter->limit)
            ->join('feeds', 'episodes.feed_id', '=', 'feeds.id')
            ->skip($filter->offset)
            ->orderBy('published_date', $filter->order)
            ->select('episodes.*', 'feeds.thumbnail_30')
            ->get();
    }

    /**
     * Valida se existe a chave no array
     * caso nao exista, retorna string vazia
     * caso exista, retorna o valor da chave
     * @param array $arr
     * @param string $key
     */
    private function getDefault($arr, $key)
    {
        if (isset($arr[$key])) {
            return $arr[$key];
        }

        return '';
    }
}
