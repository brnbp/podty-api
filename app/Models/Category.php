<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['slug', 'name', 'thumbnail', 'counter'];

    public function feeds()
    {
        return $this->belongsToMany(Feed::class, 'feed_categories' );
    }

    public function incrementsCounter()
    {
        $this->increment('counter');
    }

    public function decrementsCounter()
    {
        $this->decrement('counter');
    }
}
