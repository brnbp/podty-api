<?php
namespace App\Repositories;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FeedRepository
{
    public function findByName($name)
    {
        return Feed::where('name', 'like', "%$name%")
            ->orderBy('listeners', 'DESC')
            ->orderBy('last_episode_at', 'DESC')
            ->get();
    }

    public function first($id)
    {
        return $this->findById($id)->first();
    }

    public function all()
    {
        return Feed::all();
    }

    public function findById($id)
    {
        return Feed::whereId($id)->get();
    }

    /**
     * Busca pelos feeds que recentemente publicaram novos episodios
     * @param integer $limit limite de quantidade de retorno, por padrao, 10
     */
    public function latests($limit = 10)
    {
        return Feed::take($limit)
            ->orderBy('last_episode_at', 'DESC')
            ->get();
    }

    public function top($count)
    {
        return Feed::take($count)
            ->orderBy('listeners', 'DESC')
            ->orderBy('last_episode_at', 'DESC')
            ->get();
    }

    public function totalEpisodes($id)
    {
        return Feed::whereId($id)->select('total_episodes')->first()->toArray();
    }

    public function updateOrCreate(array $feed)
    {
        $feed = Feed::updateOrCreate([
            'url' => $feed['url']
        ], $feed);

        if ($feed->wasRecentlyCreated) {
            $feed->slug = Feed::slugfy($feed->id, $feed->name);
            $feed->save();
        }

        return $feed;
    }

    public function updateTotalEpisodes($id)
    {
        Feed::whereId($id)->update([
                'total_episodes' => (new EpisodesRepository)->getTotalEpisodes($id)
            ]);
    }

    public function updateLastEpisodeDate($id, $date)
    {
        Feed::whereId($id)->update([
                'last_episode_at' => $date
            ]);
    }

    public static function incrementsListeners($feedId)
    {
        Cache::forget('feeds_listeners_' . $feedId);
        return Feed::whereId($feedId)->increment('listeners');
    }

    public static function decrementsListeners($feedId)
    {
        Cache::forget('feeds_listeners_' . $feedId);
        return Feed::whereId($feedId)->decrement('listeners');
    }

    public static function listeners($feedId)
    {
        return Cache::remember('feeds_listeners_' . $feedId, 120, function() use ($feedId) {
            return User::where('user_feeds.feed_id', $feedId)
                ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
                ->orderBy('user_feeds.id', 'desc')
                ->get();
        });
    }
}
