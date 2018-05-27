<?php

namespace Tests\Unit;

use App\Models\Feed;
use Tests\TestCase;

class FeedTest extends TestCase
{
    /** @test */
    public function it_slugfies_an_feed()
    {
        $slug = Feed::slugfy(10, ' Random Feed Name! ');
        $this->assertEquals('10-random-feed-name', $slug);

        $slug2 = Feed::slugfy(10, ' Random Long Feed Really long long Name! ');
        $this->assertEquals('10-random-long-feed-really-long-l', $slug2);
    }
}
