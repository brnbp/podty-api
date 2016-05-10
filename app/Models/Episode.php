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
    }

    /**
     * Armazena os episodios no branco de dados
     * @param array $content array de episodios para salvar no banco
     */
    public function insert(array $content)
    {
        foreach ($content['episodes'] as $episode) {

            $ep = new EpisodeEntity();
            $ep->feedId = $content['feed_id'];
            $ep->title = $episode['title'];
            $ep->link = $episode['link'];
            $ep->publishedDate = (new \DateTime($episode['pubDate']))->format('d/m/Y H:i:s');
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
    public function getBy($field, $value, $filters)
    {
        $episodes = self::where($field, $value)
            ->skip($filters['offset'])
            ->take($filters['limit'])
            ->get();

        return $episodes->toArray();
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
