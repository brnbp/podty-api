<?php
namespace App\Repositories;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class FeedRepository
{
    /**
     * @var \App\Models\Feed $model
     */
    public $model;

    public function __construct(Feed $feed)
    {
        $this->model = $feed;
    }

    public function findByName($name)
    {
        return $this->model->by($name)->top()->get();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->whereId($id)->get();
    }

    /**
     * Busca pelos feeds que recentemente publicaram novos episodios
     *
     * @param int $count
     *
     * @return
     * @internal param int $limit limite de quantidade de retorno, por padrao, 10
     */
    public function latests($count = 10)
    {
        return $this->model
                ->latest($count)
                ->get();
    }

    public function top($count = 10)
    {
        return Cache::remember('feeds_top_' . $count, 120, function() use ($count) {
            return Feed::take($count)
                ->orderBy('listeners', 'DESC')
                ->orderBy('last_episode_at', 'DESC')
                ->get();
        });
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
