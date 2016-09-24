<?php

namespace App\Services\Parser;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;

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
        
        libxml_use_internal_errors(true);
        $sxe = simplexml_load_string($this->xmlContent, null, LIBXML_NOCDATA);

        if ($sxe === false) {
            return false;
        }

        return $sxe;
    }

    private function removeCDATA()
    {
        $this->xmlContent = str_replace(["<![CDATA[", "]]>"], "", $this->xmlContent);
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
}
