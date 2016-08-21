<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\EpisodesRepository;
use App\Repositories\UserEpisodesRepository;
use App\Repositories\UserFeedsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class UserEpisodesController extends ApiController
{
    /**
     * Get episodes from feedId
     * @param string $username
     * @param integer $feedId
     */
    public function show($username, $feedId)
    {
        $data = User::whereUsername($username)
            ->join('user_feeds', function($join) use ($feedId) {
                $join->on('users.id', '=', 'user_feeds.user_id')
                    ->where('user_feeds.feed_id', '=', $feedId);
            })
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->join('user_episodes', 'user_feeds.id','=', 'user_episodes.user_feed_id')
            ->join('episodes', 'episodes.id', '=', 'user_episodes.episode_id')
            ->select(
                'feeds.name as feed_name',
                'episodes.title as episode_title',
                'user_episodes.paused_at',
                'episodes.media_url',
                'episodes.media_type',
                'episodes.published_date',
                'episodes.content'
            )
            ->get();

        return $this->responseData($data);
    }


    public function attach($username)
    {
        $userId = UserRepository::getId($username);

        $userEpisodes = [];
        foreach (Input::get('content') as $userEpisode) {
            $feedId = EpisodesRepository::feedId($userEpisode['episode_id']);
            $userFeed = UserFeedsRepository::first($feedId, $userId);
            if (!$userFeed) {
                continue;
            }
            $userEpisodes[] = [
                'user_feed_id' => $userFeed->id,
                'episode_id' => $userEpisode['episode_id'],
                'paused_at' => $userEpisode['paused_at'],
            ];
        }

        if (!$userEpisodes) {
            return $this->respondBadRequest('User not follow feed from episodes passed');
        }

        UserEpisodesRepository::batchCreate($userEpisodes);

        return $this->responseData(['created' => true]);
    }

    public function detach($username, $episodeId)
    {
        $feedId = EpisodesRepository::feedId($episodeId);

        if (!$feedId) {
            return $this->respondNotFound();
        }

        $userId = UserRepository::getId($username);

        if (!$userId) {
            return $this->respondNotFound();
        }

        $userFeed = UserFeedsRepository::first($feedId, $userId);

        if (!$userFeed) {
            return $this->respondNotFound();
        }

        $deleted = UserEpisodesRepository::delete($userFeed->id, $episodeId);

        // TODO verificar se existe algum episodio ainda para este feed-user
        //      caso nao exista mais, marcar em user_feed, listen_all como true

        return  $deleted ?
            $this->respondSuccess(['removed' => true]) :
            $this->respondNotFound();
    }


    public function latests($username)
    {
        $data = User::whereUsername($username)
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->join('user_episodes', 'user_feeds.id','=', 'user_episodes.user_feed_id')
            ->join('episodes', 'episodes.id', '=', 'user_episodes.episode_id')
            ->select(
                'feeds.name as feed_name',
                'feeds.id as feed_id',
                'feeds.thumbnail_600 as feed_thumbnail',
                'episodes.title as episode_title',
                'user_episodes.paused_at',
                'episodes.media_url',
                'episodes.media_type',
                'episodes.published_date',
                'episodes.content'
            )
            ->orderBy('episodes.published_date', 'desc')
            ->get();

        return $this->responseData($data);

    }


    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
