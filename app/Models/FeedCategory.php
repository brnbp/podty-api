<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedCategory extends Model
{
    protected $fillable = ['feed_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
