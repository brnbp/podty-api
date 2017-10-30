<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedCategory extends Model
{
    protected $fillable = ['feed_id', 'category_id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($feedCategory){
            $feedCategory->category->incrementsCounter();
        });
        static::deleted(function($feedCategory){
            $feedCategory->category->decrementsCounter();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
