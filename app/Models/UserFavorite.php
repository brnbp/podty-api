<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected $fillable = [
        'user_id',
        'episode_id',
        'feed_id',
    ];

    protected $hidden = ['updated_at'];

    protected $with = ['episode', 'feed'];

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
