<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id', 'content_id', 'content_type', 'rate'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get all of the owning rating models.
     */
    public function content()
    {
        return $this->morphTo();
    }
}
