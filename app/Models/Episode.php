<?php

namespace App\Models;

use App\EpisodeEntity;
use App\Services\Parser\XML;
use Illuminate\Database\Eloquent\Model;

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
     * Update on Feed's table the total of episodes
     * @param integer $feed_id id of feed
     */
    private function updateTotalEpisodes($feed_id)
    {
        (new Feed())
            ->where('id', $feed_id)
            ->update(['total_episodes' => self::where('feed_id', $feed_id)->count()]);
    }

    /**
     * Armazena os episodios no branco de dados
     * @param array $content array de episodios para salvar no banco
     */
    public function insert(array $content)
    {
        foreach (array_reverse($content['episodes']) as $episode) {

            $ep = new EpisodeEntity();
            $ep->feedId = $content['feed_id'];
            $ep->title = $episode['title'];
            $ep->link = $episode['link'];
            $ep->publishedDate = (new \DateTime($episode['pubDate']))->format('Y-m-d H:i:s');
            $ep->content = $episode['description'];

            $this->validateMediaFields($episode['enclosure']['@attributes']);

            $ep->mediaUrl = $episode['enclosure']['@attributes']['url'];
            $ep->mediaLength = $episode['enclosure']['@attributes']['length'];
            $ep->mediaType = $episode['enclosure']['@attributes']['type'];

            try {
                $ep->toObject()->save();
                unset($ep);
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * Busca por episodios a partir de campo na tabela episodes
     * @param integer $id id do podcast
     * @return mixed
     */
    public function getBy($field, $value, $filters = null)
    {
        if (empty($filters)) {
            $filters = [
                'offset' => 0,
                'limit' => 10
            ];
        }

        $episodes = self::where($field, $value)
            ->select(
                'id', 'feed_id', 'title', 'link', 'published_date',
                'media_url', 'media_type', 'media_length', 'content'
            )
            ->skip($filters['offset'])
            ->take($filters['limit'])
            ->orderBy('id', 'desc')
            ->get();

        return $episodes->toArray();
    }

    /**
     * Valida se os campos de media existem, senao cria valores padr�o
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
