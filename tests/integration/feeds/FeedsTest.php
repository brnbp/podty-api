<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class FeedsTest extends TestCase
{
    use WithoutMiddleware;

    public function testTrueValue()
    {
        $this->json('GET', '/v1/feeds/latest')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name'
                    ]
                ]
            ]);
    }

}
