<?php
namespace App\Models;

use App\Jobs\RegisterEpisodesFeed;
use App\Jobs\UpdateLastEpisodeFeed;
use App\Repositories\FeedRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\Itunes\Finder as ItunesFinder;

/**
 * Class Feed
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Feed extends Model
{
    use DispatchesJobs;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany('App\Models\Episode');
    }
    
    /**
     * Get all of the post's rates.
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'content');
    }

    public function persist($name)
    {
        $newFeeds = $this->createFeeds($name);

        if (!$newFeeds) {
            return false;
        }

        $this->cronSearchForNewEpisodes($newFeeds);

        return true;
    }

    /**
     * Salva o podcast pesquisado no banco
     * @param string $name nome do podcast
     * @return bool
     */
    private function createFeeds($name)
    {
        $results = (new ItunesFinder($name))
            ->all();

        if ($results == false) {
            return false;
        }

        $response = array_map(function($feed){
            return (new FeedRepository)->updateOrCreate($feed);
        }, $results);

        return count($response) ? collect($response) : false;
    }

    /**
     * Coloca na fila todos os feeds existentes
     * para busca de novos episodios
     */
    public function cronSearchForNewEpisodes($feeds = null)
    {
        if (!$feeds) {
            $feeds = (new FeedRepository)->all();
        }

        $feeds->map(function($feed){
            $this->dispatch(new RegisterEpisodesFeed([
                'id' => $feed->id,
                'url' => $feed->url
            ]));
        });
    }

    /**
     * Atualiza a data do ultimo episodio lançado para cada feed
     * registrado no sistema
     */
    public function cronUpdateLastEpisodeAt()
    {
        $this->dispatch(new UpdateLastEpisodeFeed);
    }

    public static function slugfy($feedId, $feedName)
    {
        return $feedId . '-' . rtrim(str_limit(str_slug($feedName), 30, ''), '-');
    }
    
    public function wasRecentlyModifiedXML(string $url) :bool
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
