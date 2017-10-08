<?php
namespace App\Http\Controllers;

use App\Jobs\SearchNewFeed;
use App\Models\Feed;
use App\Repositories\FeedRepository;
use App\Transform\FeedTransformer;
use App\Transform\UserTransformer;

class FeedController extends ApiController
{
    /**
     * @var Feed
     */
    private $Feed;

    /**
     * @var FeedRepository
     */
    private $feedRepository;

    public function __construct(Feed $feed, FeedRepository $feedRepository)
    {
        $this->Feed = $feed;
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
            (new FeedTransformer)->transform($feed->toArray())
        ]);
    }

    public function latest()
    {
        return $this->response($this->feedRepository->latests());
    }

    public function top(int $count = 20)
    {
        return $this->response($this->feedRepository->top($count));
    }

    public function listeners(Feed $feed)
    {
        $users = FeedRepository::listeners($feed->id);

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
