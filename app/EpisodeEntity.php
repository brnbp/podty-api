<?php
namespace App;

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
}
