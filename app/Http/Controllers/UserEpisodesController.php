<?php
namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
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


    public function attach($username, $feedId)
    {
        $userId = UserRepository::getId($username);
        $userFeed = UserFeedsRepository::first($feedId, $userId);

        foreach (Input::get('content') as $userEpisode) {
            $userEpisodes[] = [
                'user_feed_id' => $userFeed->id,
                'episode_id' => $userEpisode['episode_id'],
                'paused_at' => $userEpisode['paused_at'],
            ];
        }

        UserEpisodesRepository::batchCreate($userEpisodes);

        return $this->responseData(['created' => true]);
    }

    public function detach($username, $episodeId)
    {
        $userFeed = UserFeedsRepository::first(
            EpisodesRepository::feedId($episodeId),
            UserRepository::getId($username)
        );

        return UserEpisodesRepository::delete($userFeed->id, $episodeId) ?
            $this->respondSuccess(['removed' => true]) : $this->respondNotFound();
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
