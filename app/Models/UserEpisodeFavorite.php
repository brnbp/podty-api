<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEpisodeFavorite extends Model
{
    protected $fillable = [
        'user_id', 'episode_id'
    ];

    protected $hidden = ['updated_at'];
}
