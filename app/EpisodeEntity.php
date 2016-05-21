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
    public $feedId;

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
    public $publishedDate;

    /**
     * @var
     */
    public $content;

    /**
     * @var
     */
    public $mediaUrl;

    /**
     * @var
     */
    public $mediaLength;

    /**
     * @var
     */
    public $mediaType;

    /**
     * @param mixed $feedId
     *
     * @return EpisodeEntity
     */
    public function setFeedId($feedId)
    {
        $this->feedId = $feedId;
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
        $this->publishedDate = (new \DateTime($publishedDate))->format('Y-m-d H:i:s');
        return $this;
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
        $this->mediaUrl = $mediaUrl ?: 'empty';
        return $this;
    }

    /**
     * @param mixed $mediaLength
     *
     * @return EpisodeEntity
     */
    public function setMediaLength($mediaLength)
    {
        $this->mediaLength = $mediaLength ?: 0;
        return $this;
    }

    /**
     * @param mixed $mediaType
     *
     * @return EpisodeEntity
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType ?: 'audio/mpeg';
        return $this;
    }



    /**
     * @return Episode
     */
    public function toObject()
    {
        $ep = new Episode();

        $ep->feed_id = $this->feedId;
        $ep->title = $this->title;
        $ep->published_date = $this->publishedDate;
        $ep->content = 'empty content for now';
        $ep->link = $this->link;
        $ep->media_length = $this->mediaLength;
        $ep->media_type = $this->mediaType;
        $ep->media_url = $this->mediaUrl;

        return $ep;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
          'feed_id' => $this->feedId,
          'title' => $this->title,
          'published_date' => $this->publishedDate,
          'content' => 'empty content for now',
          'link' => $this->link,
          'media_length' => $this->mediaLength,
          'media_type' => $this->mediaType,
          'media_url' => $this->mediaUrl
        ];
    }

    public function persist()
    {
        $ep = new Episode();

        $ep->feed_id = $this->feedId;
        $ep->title = $this->title;
        $ep->published_date = $this->publishedDate;
        $ep->content = 'empty content for now';
        $ep->link = $this->link;
        $ep->media_length = $this->mediaLength;
        $ep->media_type = $this->mediaType;
        $ep->media_url = $this->mediaUrl;

        try {
            $ep->save();
        } catch (\Exception $e) {

        }
    }
}
