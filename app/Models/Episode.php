<?php

namespace App\Models;

use App\EpisodeEntity;
use App\Jobs\RegisterEpisodesFeed;
use App\Services\Filter;
use App\Services\Parser\XML;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Episode extends Model
{
    protected $table = 'episodes';

    /**
     * Busca pelo xml com episodios a partir do id do podcast e de sua url de feed
     * @param integer $feed_id id do feed
     * @param string $feed_url url do feed
     * @return bool
     */
    public function storage($feed_id, string $feed_url)
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

        $this->updateTotalEpisodes($feed_id);

        return true;
    }

    /**
     * Armazena os episodios no branco de dados
     * @param array $content array de episodios para salvar no banco
     */
    public function insert(array $content)
    {
        foreach (array_reverse($content['episodes']) as $episode) {
            $this->validateMediaFields($episode['enclosure']['@attributes']);
            (new EpisodeEntity())
                ->setFeedId($content['feed_id'])
                ->setTitle($episode['title'])
                ->setLink($episode['link'])
                ->setPublishedDate($episode['pubDate'])
                ->setContent($episode['description'])
                ->setMediaUrl($episode['enclosure']['@attributes']['url'] ?: '')
                ->setMediaLength($episode['enclosure']['@attributes']['length'] ?: '')
                ->setMediaType($episode['enclosure']['@attributes']['type'] ?: '')
                ->persist();
        }
    }


    /**
     * Update on Feed's table the total of episodes
     * @param integer $feed_id id of feed
     */
    private function updateTotalEpisodes($feed_id)
    {
        (new Feed())
            ->where('id', $feed_id)
            ->update([
                'total_episodes' => self::where('feed_id', $feed_id)->count()
            ]);
    }

    /**
     * Busca por episodios a partir de campo na tabela episodes
     * @param integer $id id do podcast
     * @return mixed
     */
    public function getByFeedId($feedId, Filter $filter)
    {
        $feed = Feed::find($feedId);

        if (is_null($feed)) {
            return [];
        }

        return $feed
            ->episodes()
            ->select(
                'id', 'feed_id', 'title', 'link', 'published_date',
                'media_url', 'media_type', 'media_length', 'content'
            )
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
}
