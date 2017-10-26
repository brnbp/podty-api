<?php
namespace App\Services\Itunes;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Finder
 *
 * @package App\Services\Itunes
 * @see docs: https://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html
 */
class Finder
{
    const BASE_URL = 'https://itunes.apple.com/search';

    const REQUEST_METHOD = 'GET';

    private $properties = [
        'media' => 'podcast',
        'limit' => '15',
        'term' => '',
        'attribute' => 'titleTerm',
        'country' => 'BR',
    ];

    private $return_fields = [
        'collectionName',
        'feedUrl',
        'artworkUrl30',
        'artworkUrl60',
        'artworkUrl100',
        'artworkUrl600',
    ];

    /** @var GuzzleClient $client */
    private $client;

    private $results;

    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    public function all($term)
    {
        $this->properties['term'] = $term;

        $this->obtain();

        return array_map([$this, 'transform'], $this->results);
    }

    private function obtain()
    {
        $this->makeRequest();

        $this->results = $this->results ?: [];
    }

    private function makeRequest()
    {
        $this->treatResponse(
            $this->client->request(
                self::REQUEST_METHOD, self::BASE_URL, $this->getProperties()
            )
            ->getBody()
            ->getContents()
        );
    }

    private function getProperties()
    {
        return [
            'query' => http_build_query($this->properties),
        ];
    }

    private function treatResponse($response)
    {
        $response = json_decode($response, true);

        $this->filterResults($response['results']);
    }

    private function filterResults(array $results)
    {
        if (empty($results)) {
            return;
        }

        foreach ($results as $result) {
            $this->results[] = array_intersect_key($result, array_flip($this->return_fields));
        }
    }

    private function transform(array $feed)
    {
        return [
            'name' => $feed['collectionName'],
            'url' => $feed['feedUrl'],
            'thumbnail_30' => $feed['artworkUrl30'],
            'thumbnail_60' => $feed['artworkUrl60'],
            'thumbnail_100' => $feed['artworkUrl100'],
            'thumbnail_600' => $feed['artworkUrl600'],
        ];
    }
}
