<?php

namespace App\Models;

use App\EpisodeEntity;
use App\Repositories\EpisodesRepository;
use App\Repositories\FeedRepository;
use App\Services\Parser\XML;
use App\Transform\XMLTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Episode.
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Episode extends Model
{
    use RateableContent;

    protected $fillable = [
        'feed_id',
        'title',
        'published_date',
        'summary',
        'content',
        'image',
        'duration',
        'link',
        'media_length',
        'media_type',
        'media_url',
        'avg_rating',
    ];

    /** @var array $hidden The attributes that should be hidden for arrays. */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Define relação com a model Feeds, sendo que Episode pertence a um feed.
     */
    public function feed()
    {
        return $this->belongsTo(Feed::class)->first();
    }

    /**
     * Busca pelo xml com episodios a partir do id do podcast e de sua url de feed.
     *
     * @param int    $feed_id  id do feed
     * @param string $feed_url url do feed
     *
     * @return bool
     */
    public function storage($feed_id, $feed_url)
    {
        $xml = new XML();
        $content = $xml->retrieve($feed_url);

        if ($content === false) {
            return false;
        }

        $content = (new XMLTransformer($xml))->transform($content);

        $this->insert($feed_id, $content);
        (new FeedRepository(new Feed()))->updateTotalEpisodes($feed_id);

        return true;
    }

    /**
     * Armazena os episodios no banco.
     *
     * @param int   $feedId   id do feed
     * @param array $episodes array de episodios
     */
    private function insert($feedId, array $episodes)
    {
        $episodes = array_reverse($episodes);

        array_walk($episodes, function ($episode) use ($feedId) {
            (new EpisodesRepository())->save((new EpisodeEntity())
                ->setFeedId($feedId)
                ->setTitle($episode['title'])
                ->setLink($episode['link'])
                ->setPublishedDate($episode['published_date'])
                ->setSummary($episode['summary'])
                ->setDuration($episode['duration'])
                ->setImage($episode['image'])
                ->setContent($episode['content'])
                ->setMediaUrl($episode['media_url'])
                ->setMediaLength($episode['media_length'])
                ->setMediaType($episode['media_type']));
        });
    }
}
