<?php
namespace App\Models;

use App\Jobs\RegisterEpisodesFeed;
use App\Jobs\UpdateLastEpisodeFeed;
use App\Repositories\FeedRepository;
use App\Services\Filter;
use App\Services\Queue;
use Illuminate\Database\Eloquent\Collection;
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
        'url', 'name', 'thumbnail_30', 'thumbnail_60', 'thumbnail_100', 'thumbnail_600'
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
}
