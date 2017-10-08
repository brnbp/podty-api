<?php
namespace App\Http\Controllers;

use App\Events\ContentRated;
use App\Filter\Filter;
use App\Http\Requests\RatingRequest;
use App\Models\Episode;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\UserEpisodesRepository;
use App\Repositories\UserFeedsRepository;
use App\Transform\EpisodeTransformer;
use App\Transform\FeedTransformer;
use Illuminate\Support\Facades\Cache;

class UserEpisodesController extends ApiController
{
    private $filter;

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function one(User $user, Episode $episode)
    {
        $userFeed = UserFeedsRepository::first($episode->feed(), $user);

        $userEpisode = UserEpisodesRepository::first($userFeed->id, $episode->id);

        $episode = (new EpisodeTransformer)->transform($episode->toArray());
        $episode['paused_at'] = $userEpisode['paused_at'];

        return $this->responseData($episode);
    }

    public function show(User $user, Feed $feed)
    {
        $episodes = UserEpisodesRepository::retrieve($user, $feed);

        if ($episodes->isEmpty()) {
            return $this->respondNotFound();
        }

        $feed = (new FeedTransformer)->transform($feed);
        $feed['episodes'] = $episodes->toArray();

        return $this->responseData($feed);
    }

    public function latests(User $user)
    {
        if ($this->filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $latestsEpisodes = (new UserEpisodesRepository)
                                ->latests($user->username, $this->filter);

        $response = $latestsEpisodes->map(function($episode) {
            $feed = (new FeedTransformer)->transform($episode);
            $ep = (new EpisodeTransformer)->transform($episode);
            $ep['paused_at'] = $episode['paused_at'];
            $feed['episode'] = $ep;
            unset($feed['episodes']);
            return $feed;
        });

        return $this->responseData($response);
    }

    public function listening($username)
    {
        $listening = (new UserEpisodesRepository)->listening($username);

        $response = $listening->map(function($episode) {
            $feed = (new FeedTransformer)->transform($episode);
            $ep = (new EpisodeTransformer)->transform($episode);
            $ep['paused_at'] = $episode['paused_at'];
            $feed['episode'] = $ep;
            unset($feed['episodes']);
            return $feed;
        });

        if (!$response->count()) {
            return $this->respondNotFound();
        }

        return $this->responseData($response);
    }

    public function attach(User $user, Episode $episode)
    {
        $userFeed = UserFeedsRepository::first($episode->feed(), $user);

        Cache::forget('user_episodes_latests_' . $user->username);
        Cache::forget('user_episodes_' . $user->username);

        UserEpisodesRepository::create([
            'user_feed_id' => $userFeed->id,
            'episode_id' => $episode->id,
            'paused_at' => 0,
        ]);

        if (UserEpisodesRepository::hasEpisodes($userFeed->id)) {
            UserFeedsRepository::markAllListened($userFeed->id, false);
        }

        return $this->respondCreated();
    }

    public function detach(User $user, Episode $episode)
    {
        $userFeed = UserFeedsRepository::first($episode->feed(), $user);

        UserEpisodesRepository::delete($userFeed, $episode);

        if (UserEpisodesRepository::hasEpisodes($userFeed->id) == false) {
            UserFeedsRepository::markAllListened($userFeed->id);
        }

        Cache::forget('user_episodes_latests_' . $user->username);
        Cache::forget('user_episodes_' . $user->username);

        return  $this->respondSuccess();
    }

    public function paused(User $user, Episode $episode, $time)
    {
        $userFeed = UserFeedsRepository::first($episode->feed(), $user);

        UserEpisodesRepository::markAsPaused($userFeed->id, $episode->id, $time);

        return $this->respondSuccess(['updated' => true]);
    }

    public function rate(RatingRequest $request, User $user, Episode $episode)
    {
        $rate = $episode->ratings()->updateOrCreate(
            ['user_id' => $user->id,],
            ['rate' => $request->rate]
        );

        event(new ContentRated($episode, Episode::class));

        return $rate->wasRecentlyCreated ?
            $this->respondCreated($rate) :
            $this->respondSuccess($rate);
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
