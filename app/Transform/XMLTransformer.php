<?php

namespace App\Transform;

use App\Services\Parser\XML;

/**
 * Class XMLTransformer.
 */
class XMLTransformer extends TransformerAbstract
{
    /**
     * @var \App\Services\Parser\XML
     */
    private $xml;

    public function __construct(XML $xml)
    {
        $this->xml = $xml;
    }

    /**
     * Transforma um feed para um retorno padrao.
     *
     * @param $feedXML
     *
     * @return array
     */
    public function transform($feedXML)
    {
        $episodes = [];
        foreach ($feedXML->channel->item as $entry) {
            $nsElements = $this->getNamespaceChildren($entry);

            $enclosure = $this->getEnclosureAttributes($entry->enclosure->attributes());

            $episodes[] = [
                'title'          => array_first($entry->title),
                'link'           => array_first($entry->link) ?? '',
                'published_date' => array_first($entry->pubDate) ?? '',
                'content'        => array_first($entry->description) ?? '',
                'summary'        => array_first($nsElements->summary ?? []) ?? '',
                'image'          => $this->getImageUrl($nsElements),
                'duration'       => array_first($nsElements->duration ?? []) ?? '',
                'media_url'      => $enclosure['@attributes']['url'] ?? '',
                'media_length'   => $enclosure['@attributes']['length'] ?? 0,
                'media_type'     => $enclosure['@attributes']['type'] ?? 'audio/mp3',
            ];
        }

        return $episodes;
    }

    private function getNamespaceChildren($entry)
    {
        $itunesNamespace = $this->xml->getItunesNamespace($entry);

        return $entry->children($itunesNamespace);
    }

    private function getImageUrl($nsElements)
    {
        if (!isset($nsElements->image)) {
            return '';
        }

        if (!isset($nsElements->image->attributes()->href)) {
            return '';
        }

        return reset($nsElements->image->attributes()->href);
    }

    private function getEnclosureAttributes($attrs = [])
    {
        return json_decode(json_encode($attrs), true);
    }
}
