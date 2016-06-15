<?php
namespace App\Transform;

/**
 * Class FeedTransformer
 *
 * @package App\Transform
 */
class FeedTransformer extends TransformerAbstract
{
    /**
     * Transforma um feed para um retorno padrao
     * @param $feed
     *
     * @return array
     */
    public function transform($feed)
    {
        return [
            'id' => $feed['id'],
            'name' => $feed['name'],
            'url' => $feed['url'],
            'thumbnail_30' => $feed['thumbnail_30'],
            'thumbnail_60' => $feed['thumbnail_60'],
            'thumbnail_100' => $feed['thumbnail_100'],
            'thumbnail_600' => $feed['thumbnail_600'],
            'total_episodes' => $feed['total_episodes'],
            'last_episode_at' => $feed['last_episode_at'],
            'last_search' => $feed['updated_at']
        ];

    }
}
