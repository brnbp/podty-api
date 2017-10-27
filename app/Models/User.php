<?php
namespace App\Models;

use App\Mail\UserRegistered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class User extends Model
{
    protected $fillable = ['username', 'email', 'password', 'friends_count', 'podcasts_count'];

    protected $hidden = ['remember_token'];

    protected static function boot()
    {
        parent::boot();

        static::created(function (User $user) {
            Mail::send(new UserRegistered($user));
        });
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
