<?php
namespace App\Transform;

/**
 * Class FeedTransformer
 *
 * @package App\Transform
 */
class FeedTransformer extends TransformerAbstract
{
    public function transform($feed, $withoutEpisodes = false)
    {
        $feed = [
            'id' => $feed['id'],
            'name' => $feed['name'],
            'slug' => $feed['slug'],
            'url' => $feed['url'],
            'description' => $feed['description'],
            'thumbnail_30' => $feed['thumbnail_30'],
            'thumbnail_60' => $feed['thumbnail_60'],
            'thumbnail_100' => $feed['thumbnail_100'],
            'thumbnail_600' => $feed['thumbnail_600'],
            'color' => $feed['main_color'],
            'total_episodes' => $feed['total_episodes'],
            'listeners' => $feed['listeners'],
            'last_episode_at' => $feed['last_episode_at'],
            'episodes' => [],
        ];

        if ($withoutEpisodes) {
            unset($feed['episodes']);
        }

        return $feed;
    }
}
