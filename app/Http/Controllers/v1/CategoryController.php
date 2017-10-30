<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryController extends ApiController
{
    public function all()
    {
        return Category::all();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function feeds(Category $category)
    {
        return $category->feeds();
    }
}
