<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEpisode extends Model
{
    protected $fillable = [
        'user_feed_id', 'episode_id', 'paused_at',
    ];

    public function user()
    {
        return $this->belongsTo(UserFeed::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
