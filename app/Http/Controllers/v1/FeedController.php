<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Jobs\SearchNewFeed;
use App\Models\Feed;
use App\Repositories\FeedRepository;
use App\Transform\FeedTransformer;
use App\Transform\UserTransformer;
use Illuminate\Support\Facades\Cache;

class FeedController extends ApiController
{
    /**
     * @var FeedRepository
     */
    private $feedRepository;

    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function retrieve($name)
    {
        $feed = $this->feedRepository->findByName($name);

        if ($feed->isEmpty()) {
            $this->dispatch(new SearchNewFeed($name));
        }

        return $this->response($feed);
    }

    public function retrieveById(Feed $feed)
    {
        return $this->respondSuccess([
            (new FeedTransformer)->transform($feed->toArray()),
        ]);
    }

    public function latest()
    {
        return $this->response($this->feedRepository->latests());
    }

    public function top(int $count = 20)
    {
        $feeds = Cache::remember('feeds_top_' . $count, 120, function () use ($count) {
            return $this->feedRepository->top($count);
        });

        return $this->response($feeds);
    }

    public function listeners(Feed $feed)
    {
        $users = Cache::remember('feeds_listeners_' . $feed->id, 120, function () use ($feed) {
            return FeedRepository::listeners($feed->id);
        });

        if (!$users->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess(
            (new UserTransformer())->transformCollection($users->toArray())
        );
    }

    public function response($collection)
    {
        if ($collection->isEmpty()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess(
            (new FeedTransformer)->transformCollection($collection->toArray())
        );
    }
}
