<?php

namespace App\Services\Parser;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Http\Client\Exception\RequestException;

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
     * XML constructor.
     *
     * @param string $xml_path
     */
    public function __construct($xml_path)
    {
        $this->xmlPath = $xml_path;
    }

    /**
     * Obtains XML content in array format or false if not capable
     *
     *@return array|boolean return array with xml content or false
     */
    public function retrieve()
    {
        $this->xmlContent = $this->getContent();

        if ($this->xmlContent === false) {
            return false;
        }
        return $this->getXMLData();
    }

    /**
     * Gets the xml content with Guzzle
     * @return bool|string returns xml with string format or false if not possible
     */
    public function getContent()
    {
        $guzzle = new GuzzleClient();
        try {
            $response = $guzzle->request('GET', $this->xmlPath);
        } catch (ClientException $Exception) {
            return false;
        } catch (RequestException $Exception) {
            return false;
        } catch (ServerException $Exception) {
            return false;
        }

        return $response->getBody()->getContents();
    }

    /**
     * obtains xml content with array format
     * @return array|boolean  returns an array of content or false if not possible
     */
    private function getXMLData()
    {
        $object = $this->xmlStringToObject();

        if ($object == false) {
            return false;
        }

        return $this->objectToArray($object);
    }

    /**
     * Parse xml string to SimpleXMLElement object
     * @return mixed
     */
    private function xmlStringToObject()
    {
        return simplexml_load_string($this->xmlContent, null, LIBXML_NOCDATA);
    }

    /**
     * Parse XML Object to Array
     * @param \SimpleXMLElement $object
     *
     * @return mixed
     */
    private function objectToArray(\SimpleXMLElement $object)
    {
        return json_decode(json_encode($object), true);
    }
}
