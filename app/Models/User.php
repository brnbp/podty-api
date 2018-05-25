<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['username', 'email', 'password', 'friends_count', 'podcasts_count'];

    protected $hidden = ['remember_token'];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

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
