<?php

namespace App\Services\Parser;

class XML
{
    private $xml_path;
    
    private $xml_object;

    public function __construct($xml_path)
    {
        $this->xml_path = $xml_path;
    }

    public function retrieve()
    {
        $this->xml_object = file_get_contents($this->xml_path);
        return $this->getXMLData();
    }

    private function getXMLData()
    {
        $object = simplexml_load_string($this->xml_object, null, LIBXML_NOCDATA);

        return $this->objectToArray($object);
    }

    private function objectToArray($object)
    {
        return json_decode(json_encode($object), true);
    }
}
