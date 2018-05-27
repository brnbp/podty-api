<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Transform\CategoryTransformer;
use App\Transform\FeedTransformer;
use Illuminate\Support\Facades\Cache;

class CategoryController extends ApiController
{
    /**
     * @var \App\Transform\CategoryTransformer
     */
    protected $transformer;

    public function __construct(CategoryTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function all()
    {
        $categories = Cache::remember('categories.all', 360, function () {
            return Category::orderBy('name')->get()->toArray();
        });

        return $this->respondSuccess(
            $this->transformer->transformCollection($categories)
        );
    }

    public function show(Category $category)
    {
        return $this->respondSuccess(
            $this->transformer->transform($category)
        );
    }

    public function feeds(Category $category)
    {
        $cacheHash = "categories.{$category->id}.feeds";

        $feeds = Cache::remember($cacheHash, 360, function () use ($category) {
            return $category->feeds()->with('categories')->get();
        });

        if ($feeds->isEmpty()) {
            return $this->respondNotFound();
        }

        $response = $feeds->map(function ($feed) {
            $return = (new FeedTransformer())->transform($feed);
            unset($return['episodes']);

            return $return;
        });

        return $this->respondSuccess($response);
    }
}
