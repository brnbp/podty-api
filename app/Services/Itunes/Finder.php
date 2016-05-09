<?php

namespace App\Services\Itunes;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Finder
 * @package App\Services\Itunes
 * @see docs: https://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html
 */
class Finder
{
    const BASE_URL = 'https://itunes.apple.com/search';

    const REQUEST_METHOD = 'GET';

    private $properties = [
        'media' => 'podcast',
        'country' => 'BR',
        'lang' => 'pt_br',
        'limit' => '2',
        'term' => '',
        'attribute' => 'titleTerm'
    ];

    private $return_fields = [
        'collectionName',
        'feedUrl',
        'artworkUrl30',
        'artworkUrl60',
        'artworkUrl100',
        'artworkUrl600'
    ];

    /** @var GuzzleClient $GuzzleClient */
    private $GuzzleClient;

    private $results;
    private $result_count;

    public function __construct($term)
    {
        $this->properties['term'] = $term;
        $this->GuzzleClient = new GuzzleClient();
    }

    public function first()
    {
        $this->properties['limit'] = '1';
        $this->obtain();
        return $this->results;
    }

    public function all()
    {
        $this->obtain();
        return $this->results;
    }

    private function obtain()
    {
        $this->makeRequest();

        $this->results = $this->results ? : false;
    }

    private function makeRequest()
    {
        $this->treatResponse(
            $this->GuzzleClient->request(
                self::REQUEST_METHOD, self::BASE_URL, $this->getProperties()
            )
            ->getBody()
            ->getContents()
        );
    }

    private function getProperties()
    {
        return [
            'query' => http_build_query($this->properties)
        ];
    }

    private function treatResponse($response)
    {
        $response = json_decode($response, true);

        $this->result_count = $response['resultCount'];
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
}

