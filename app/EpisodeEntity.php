<?php
/**
 * Created by PhpStorm.
 * User: bruno2546
 * Date: 24/04/16
 * Time: 14:43
 */

namespace App;

use App\Episode;

class EpisodeEntity
{
    public $feedId;

    public $title;

    public $link;

    public $publishedDate;

    public $content;

    public $mediaUrl;

    public $mediaLength;

    public $mediaType;

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
