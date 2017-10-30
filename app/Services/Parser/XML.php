<?php
namespace App\Services\Parser;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

/**
 * Class XML
 *
 * @package App\Services\Parser
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class XML
{
    /**
     * @var string
     */
    private $xmlPath;

    /**
     * @var string
     */
    private $xmlContent;

    /**
     * Obtains XML content in array format or false if not capable
     *
     * @param string $xml_path
     *
     * @return array|bool return array with xml content or false
     */
    public function retrieve(string $xml_path)
    {
        $this->xmlPath = $xml_path;

        $this->xmlContent = $this->getContent();

        if ($this->xmlContent === false) {
            return false;
        }

        libxml_use_internal_errors(true);
        $sxe = simplexml_load_string($this->xmlContent, null, LIBXML_NOCDATA);

        if ($sxe === false) {
            $errors = [];
            foreach (libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }
            Log::info(json_encode([
                'xml_path' => $this->xmlPath,
                'error' => $errors,
            ]));

            return false;
        }

        return $sxe;
    }

    /**
     * Gets the xml content with Guzzle
     *
     * @return bool|string returns xml with string format or false if not possible
     */
    protected function getContent()
    {
        $guzzle = new GuzzleClient();

        try {
            $response = $guzzle->request('GET', $this->xmlPath);
        } catch (\Exception $exception) {
            return false;
        }

        return $response->getBody()->getContents();
    }

    public function getItunesNamespace($xml)
    {
        $namespaces = $xml->getNameSpaces(true);
        return $namespaces['itunes'] ?? array_first($namespaces);
    }

    public function getCategories($content)
    {
        $itunesNamespace = $this->getItunesNamespace($content);
        $nsElements = $content->channel->children($itunesNamespace);

        $categories = collect();
        foreach ($nsElements->category as $category) {
            $categories->push((string) $category->attributes());
        }

        return $categories;
    }
}
