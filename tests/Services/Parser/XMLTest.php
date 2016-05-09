<?php

use App\Services\Parser\XML;

class XMLTest extends TestCase
{
    /**
     * @var XML $XML
     */
    private $XML;

    public function setUp()
    {
        $this->XML = new XML('https://geekout.fm/feed.xml');
    }

    public function testConstruct()
    {
        $this->assertObjectHasAttribute('xmlPath', $this->XML);
        $this->assertObjectHasAttribute('xmlContent', $this->XML);
        $this->assertAttributeInternalType('string', 'xmlPath', $this->XML);
    }

    public function testGetInvalidContent()
    {
        $XML = new XML('http://invalidUrl.com');
        $this->assertFalse($XML->getContent());
    }

    public function testGetValidContent()
    {
        $this->assertTrue(is_array($this->XML->retrieve()));
    }

    public function testValidResponse()
    {
        $this->assertArrayHasKey('item', $this->XML->retrieve()['channel']);
    }
}
