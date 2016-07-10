<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserFeed extends Model
{
    protected $fillable = ['user_id', 'feed_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('user');
    }
}
