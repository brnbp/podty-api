<?php
namespace App\Transform;

class EpisodeTransformer extends TransformerAbstract
{
    /**
     * Transforma um feed para um retorno padrao
     *
     * @param $feed
     *
     * @return array
     */
    public function transform($episode)
    {
        return [
            'id' => $episode['id'],
            'title' => $episode['title'],
            'link' => $episode['link'] ?? '',
            'published_at' => $episode['published_date'],
            'content' => $episode['content'] ?? '',
            'summary' => $episode['summary'] ?? '',
            'image' => $episode['image'] ?? '',
            'duration' => $episode['duration'] ?? '',
            'media_url' => $episode['media_url'] ?? '',
            'media_length' => $episode['media_length'] ?? '',
            'media_type' => $episode['media_type'] ?? '',
        ];
    }
}
