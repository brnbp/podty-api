<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected $fillable = [
        'user_id', 'episode_id'
    ];

    protected $hidden = ['updated_at'];
    
    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
