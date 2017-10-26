<?php
namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Feed
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Feed extends Model
{
    use DispatchesJobs, RateableContent;

    protected $fillable = [
        'url', 'name', 'slug', 'thumbnail_30',
        'thumbnail_60', 'thumbnail_100',
        'thumbnail_600', 'total_episodes',
        'listeners','last_episode_at',
        'avg_rating'
    ];

    /** @var array $hidden The attributes that should be hidden for arrays. */
    protected $hidden = ['created_at'];

    /**
     * Define relação com a model Episodes, sendo que Feed possui varios episodios
     * ligados a ele
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany('App\Models\Episode');
    }

    public function scopeBy($builder, $name)
    {
        return $builder->where('name', 'like', "%{$name}%");
    }

    public function scopeLatest($builder, $count = 10)
    {
        return $builder->take($count)->orderBy('last_episode_at', 'DESC');
    }

    public function scopeTop($builder, $count = 10)
    {
        return $builder->take($count)
                    ->orderBy('listeners', 'DESC')
                    ->orderBy('last_episode_at', 'DESC');
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function($feed) {
            if (!$feed->slug){
                $feed->slug = self::slugfy($feed->id, $feed->name);
                $feed->save();
            }
        });
    }

    public static function slugfy($feedId, $feedName)
    {
        return $feedId . '-' . rtrim(str_limit(str_slug($feedName), 30, ''), '-');
    }

    public function wasRecentlyModifiedXML(string $url): bool
    {
        $lastModified = (new Client)->head($url)->getHeader('Last-Modified') ?? [];

        $lastModified = reset($lastModified);

        if (!$lastModified) {
            return true;
        }

        $lastModified = Carbon::createFromFormat('D, d M Y H:i:s T', $lastModified);

        $isDawn = Carbon::now()->hour > 1 && Carbon::now()->hour < 6;

        return $lastModified->gte(Carbon::now()->subHour(12)) || $isDawn;
    }
}
