<?php
namespace App\Transform;

class CategoryTransformer extends TransformerAbstract
{
    public function transform($category)
    {
        return [
            'id' => $category['id'],
            'name' => $category['name'],
            'slug' => $category['slug'],
            'thumbnail' => $category['thumbnail'] ?? '',
            'counter' => $category['counter'],
        ];
    }
}
