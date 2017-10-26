<?php
namespace App\Repositories;

use App\EpisodeEntity;
use App\Filter\Filter;
use App\Models\Episode;
use App\Models\Feed;
use App\Models\UserFeed;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class EpisodesRepository
{
    public static function first($episodeId)
    {
        return Episode::whereId($episodeId)->firstOrFail();
    }

    public function one($episodeId)
    {
        return Episode::whereId($episodeId)->first();
    }

    public static function exists($episodeId)
    {
        return self::first($episodeId) ? true : false;
    }

    public function retrieveByFeed(Feed $feed, Filter $filter)
    {
        $episodes = $feed->episodes()
                        ->take($filter->limit)
                        ->skip($filter->offset)
                        ->where('title', 'LIKE', "%{$filter->term}%")
                        ->orderBy('published_date', $filter->order)
                        ->get();

        if ($episodes->isEmpty()) {
            return false;
        }

        return $episodes;
    }

    /**
     * @param integer $feedId id of feed
     */
    public function getTotalEpisodes($feedId)
    {
        return Episode::whereFeedId($feedId)->count();
    }

    public function latests(Filter $filter)
    {
        return Episode::take($filter->limit)
            ->skip($filter->offset)
            ->orderBy('published_date', $filter->order)
            ->get();
    }

    public function save(EpisodeEntity $episodeEntity)
    {
        try {
            $episode = Episode::updateOrCreate([
                'title' => $episodeEntity->title,
                'feed_id' => $episodeEntity->feed_id,
                'published_date' => $episodeEntity->getPublishedDate(),
            ], $episodeEntity->toArray());

            return $episode->exists;
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);

            return false;
        }
    }

    public function addToListeners(Episode $episode)
    {
        $usersFeed = UserFeed::whereFeedId($episode->feed_id)->get();

        foreach ($usersFeed as $userFeed) {
            UserEpisodesRepository::create([
                'user_feed_id' => $userFeed->id,
                'episode_id' => $episode->id,
                'paused_at' => 0,
            ]);
        }
    }
}
