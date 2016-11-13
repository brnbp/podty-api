<?php

namespace App\Repositories;

use App\EpisodeEntity;
use App\Filter\Filter;
use App\Models\Episode;
use App\Models\User;
use App\Models\UserFeed;
use Illuminate\Database\Eloquent\Builder;

class EpisodesRepository
{
    public static function feedId($episodeId)
    {
        $episode = Episode::whereId($episodeId)->first();
        return $episode ? $episode->feed_id : false;
    }

    public function retriveByFeedId($feedId, Filter $filter)
    {
        $episodes = Episode::take($filter->limit)
                ->skip($filter->offset)
                ->orderBy('published_date', $filter->order)
                ->whereFeedId($feedId)
                ->where('title', 'LIKE', "%$filter->term%")
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
            ->join('feeds', 'episodes.feed_id', '=', 'feeds.id')
            ->skip($filter->offset)
            ->orderBy('published_date', $filter->order)
            ->select(
                'episodes.*',
                'feeds.name',
                'feeds.slug',
                'feeds.thumbnail_30',
                'feeds.thumbnail_60',
                'feeds.thumbnail_100',
                'feeds.thumbnail_600'
            )
            ->get();
    }

    public function save(EpisodeEntity $episodeEntity)
    {
        $episode = Episode::updateOrCreate([
            'media_url' => $episodeEntity->media_url
        ], $episodeEntity->toArray());

        if ($episode->wasRecentlyCreated) {

            $this->updateAllUsersWhoFollowsIt($episode);

        }

        return $episode->exists;
    }

    public static function getIdsByFeed($feedId)
    {
        $episodes = Episode::whereFeedId($feedId)->select('id')->get();

        return $episodes->map(function($item){
            return $item->id;
        });
    }

    private function updateAllUsersWhoFollowsIt($episode)
    {
        $usersFeed = UserFeed::whereFeedId($episode->feed_id)->get();

        foreach ($usersFeed as $userFeed) {
            UserEpisodesRepository::create([
                'user_feed_id' => $userFeed->id,
                'episode_id' => $episode->id,
                'paused_at' => 0
            ]);
        }
    }
}
