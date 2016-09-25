<?php
namespace App\Http\Controllers;

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
            ->orderBy('episodes.published_date', 'desc')
            ->get();

        return $this->responseData($data);
    }

    public function attach($username)
    {
        $userId = UserRepository::getId($username);
        if (!$userId) {
            return $this->respondNotFound('user not found');
        }

        $content = Input::get('content');
        if (!$content) {
            return $this->respondBadRequest('payload not acceptable');
        }

        $userEpisodes = [];
        foreach ($content as $episode) {
            $userFeedId = UserFeedsRepository::idByEpisodeAndUser($episode['id'], $userId);
            if (!$userFeedId) {
                continue;
            }
            $userEpisodes[] = [
                'user_feed_id' => $userFeedId,
                'episode_id' => $episode['id'],
                'paused_at' => $episode['paused_at'],
            ];
        }

        if (!$userEpisodes) {
            return $this->respondBadRequest('User not follow feed from episodes passed');
        }

        UserEpisodesRepository::batchCreate($userEpisodes);

        if (UserEpisodesRepository::hasEpisodes($userFeedId)) {
            UserFeedsRepository::markAllListened($userFeedId, false);
        }

        return $this->responseData(['created' => true]);
    }

    public function detach($username, $episodeId)
    {
        $userFeedId = UserFeedsRepository::idByEpisodeAndUsername($episodeId, $username);
        if (!$userFeedId) {
            return $this->respondNotFound('User not follow feed from episodes passed');
        }

        $deleted = UserEpisodesRepository::delete($userFeedId, $episodeId);

        if (UserEpisodesRepository::hasEpisodes($userFeedId) == false) {
            UserFeedsRepository::markAllListened($userFeedId);
        }

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

    public function paused($username, $episodeId)
    {
        $userFeedId = UserFeedsRepository::idByEpisodeAndUsername($episodeId, $username);
        if (!$userFeedId) {
            return $this->respondNotFound('User not follow feed from episodes passed');
        }

        $time = Input::get('time');

        if (!$time) {
            return $this->respondBadRequest();
        }

        UserEpisodesRepository::markAsPaused($userFeedId, $episodeId, $time);

        return $this->respondSuccess(['updated' => true]);
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
