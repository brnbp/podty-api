<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Repositories\FeedRepository;
use App\Transform\FeedTransformer;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

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
            $this->Feed->persist($name);
        }

        return $this->response($feed);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveById($id)
    {
        $feed = $this->feedRepository->findById($id);

        return $this->response($feed);
    }

    public function latest()
    {
        $latestsFeeds = $this->feedRepository->latests();

        return $this->response($latestsFeeds);
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
