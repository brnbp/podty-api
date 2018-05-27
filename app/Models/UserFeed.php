<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFeed extends Model
{
    protected $fillable = ['user_id', 'feed_id'];

    protected $casts = ['listen_all' => 'boolean'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function episodes()
    {
        return $this->hasMany(UserEpisode::class);
    }
}
