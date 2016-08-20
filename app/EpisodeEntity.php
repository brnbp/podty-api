<?php
namespace App;

use App\Models\Episode;
use Doctrine\DBAL\Query\QueryException;

/**
 * Class EpisodeEntity
 *
 * @package App
 */
class EpisodeEntity
{
    /**
     * @var
     */
    public $feed_id;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $link;

    /**
     * @var
     */
    public $published_date;

    /**
     * @var
     */
    public $content;

    /**
     * @var
     */
    public $media_url;

    /**
     * @var
     */
    public $media_length;

    /**
     * @var
     */
    public $media_type;
    
    /**
     * @param mixed $feedId
     *
     * @return EpisodeEntity
     */
    public function setFeedId($feedId)
    {
        $this->feed_id = $feedId;
        return $this;
    }

    /**
     * @param mixed $title
     *
     * @return EpisodeEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $link
     *
     * @return EpisodeEntity
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param mixed $publishedDate
     *
     * @return EpisodeEntity
     */
    public function setPublishedDate($publishedDate)
    {
        $this->published_date = (new \DateTime($publishedDate))->format('Y-m-d H:i:s');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedDate()
    {
        return $this->published_date;
    }

    /**
     * @param mixed $content
     *
     * @return EpisodeEntity
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param mixed $mediaUrl
     *
     * @return EpisodeEntity
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->media_url = $mediaUrl ?: 'empty';
        return $this;
    }

    /**
     * @param mixed $mediaLength
     *
     * @return EpisodeEntity
     */
    public function setMediaLength($mediaLength)
    {
        $this->media_length = $mediaLength ?: 0;
        return $this;
    }

    /**
     * @param mixed $mediaType
     *
     * @return EpisodeEntity
     */
    public function setMediaType($mediaType)
    {
        $this->media_type = $mediaType ?: 'audio/mp3';
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
          'feed_id' => $this->feed_id,
          'title' => $this->title,
          'published_date' => $this->published_date,
          'content' => $this->content,
          'link' => $this->link,
          'media_length' => $this->media_length,
          'media_type' => $this->media_type,
          'media_url' => $this->media_url
        ];
    }
}
