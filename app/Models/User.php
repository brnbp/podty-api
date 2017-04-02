<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['username', 'email', 'password', 'friends_count', 'podcasts_count'];

    protected $hidden = ['password', 'remember_token'];

    public static $rules = [
        'username' => 'bail|required|alpha_num|unique:users|min:3|max:20',
        'email' => 'bail|required|email|unique:users',
        'password' => 'bail|required|string|min:5'
    ];

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
        return $this->hasMany(UserEpisodeFavorite::class);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}
