<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['username', 'email', 'password', 'friends_count', 'podcasts_count'];

    protected $hidden = ['remember_token'];

    public function feeds()
    {
        return $this->hasMany(UserFeed::class);
    }

    public function friends()
    {
        return $this->hasMany(UserFriend::class);
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}
