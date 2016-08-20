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
        $newFeed = $this->createFeeds($name);

        if (!$newFeed) {
            return false;
        }

        $feeds = array_map(function($feed){
            return $feed->toArray();
        }, $newFeed);

        (new Queue)->searchNewEpisodes($feeds);

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

        return count($response) ? $response : false;
    }

    /**
     * Update or Create content
     * @param array $content array of contents being ['field' => 'value']
     * @param array $filter array of filters being ['field' => 'value']
     * @param bool $insert sets for insert if not exists, default is false
     *
     * @return bool|int
     */
    public function upsert(array $content, array $filter, $insert = false)
    {
        if ($insert) {
            return self::updateOrCreate($filter, $content);
        }

        return self::update($content, $filter);
    }

    public function getUrlById($id)
    {
        $feed = self::where('id', $id)->get();

        $content = $feed->toArray();

        return reset($content)['url'];
    }

    /**
     * Coloca na fila todos os feeds existentes
     * para busca de novos episodios
     */
    public function cronSearchForNewEpisodes($feeds = null)
    {
        if (!$feeds) {
            $feeds = self::all(['url', 'id'])->toArray();
        }

        foreach ($feeds as $feed) {
            $this->dispatch(new RegisterEpisodesFeed($feed));
        }

        return $this;
    }

    /**
     * Atualiza a data do ultimo episodio lançado para cada feed
     * registrado no sistema
     */
    public function cronUpdateLastEpisodeAt()
    {
        $this->dispatch(new UpdateLastEpisodeFeed);

        return $this;
    }
}
