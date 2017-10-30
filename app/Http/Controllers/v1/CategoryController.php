<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Transform\CategoryTransformer;
use App\Transform\FeedTransformer;

class CategoryController extends ApiController
{
    /**
     * @var \App\Transform\CategoryTransformer $categoryTransformer
     */
    protected $transformer;

    public function __construct(CategoryTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function all()
    {
        return $this->respondSuccess(
            $this->transformer->transformCollection(
                Category::orderBy('name')->get()->toArray()
            )
        );
    }

    public function show(Category $category)
    {
        return $this->respondSuccess(
            $this->transformer->transform(
                $category
            )
        );
    }

    public function feeds(Category $category)
    {
        $feeds = $category->feeds()->with('categories')->get();

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
