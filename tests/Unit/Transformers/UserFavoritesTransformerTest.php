<?php
namespace Tests\Unit\Transformers;

use App\Transform\UserFavoritesTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserFavoritesTransformerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_transforms()
    {
        $input = [
            "id" => 1,
            "user_id" => "1",
            "feed_id" => "1",
            "episode_id" => "1",
            "created_at" => "2018-06-30 12:28:10",
            "episode" => [
                "id" => 1,
                "feed_id" => "1",
                "title" => "laborum dolorem praesentium",
                "link" => "http://www.von.com/iure-voluptas-excepturi-laborum-laborum-autem-ratione-necessitatibus-libero.html",
                "published_date" => "2018-06-29 12:28:09",
                "content" => "Qui rerum voluptatem architecto consequatur ",
                "media_url" => "https://www.kreiger.com/non-sed-similique-dolores-deserunt-quia",
                "media_length" => "161656",
                "media_type" => "audio/mpeg",
                "image" => "https://lorempixel.com/640/480/?68816",
                "duration" => "02:30:42",
                "summary" => "Voluptnis. Consectetur voluptate odio harum quo ea.",
                "avg_rating" => "0.0",
            ],
            "feed" => [
                "id" => 1,
                "name" => "sit rem amet",
                "url" => "https://www.altenwerth.com/nulla-assumenda-quia-aut-dolorem-impedit",
                "thumbnail_30" => "https://lorempixel.com/640/480/?72279",
                "thumbnail_60" => "https://lorempixel.com/640/480/?26416",
                "thumbnail_100" => "https://lorempixel.com/640/480/?20953",
                "thumbnail_600" => "https://lorempixel.com/640/480/?77870",
                "total_episodes" => "84",
                "last_episode_at" => "2018-06-30 12:28:09",
                "updated_at" => "2018-06-30 12:28:09",
                "listeners" => "68",
                "slug" => "1-sit-rem-amet",
                "avg_rating" => "0.0",
                "description" => "temporibus cupiditate quis sunt cupiditate",
                "main_color" => "#f2a107",
                "itunes_id" => "155983",
            ],
        ];

        $expectatedTransformed = [
            "id" => 1,
            "user_id" => "1",
            "feed_id" => "1",
            "episode_id" => "1",
            "created_at" => "2018-06-30 12:28:10",
            "episode" =>  [
                "id" => 1,
                "title" => "laborum dolorem praesentium",
                "link" => "http://www.von.com/iure-voluptas-excepturi-laborum-laborum-autem-ratione-necessitatibus-libero.html",
                "published_at" => "2018-06-29 12:28:09",
                "content" => "Qui rerum voluptatem architecto consequatur ",
                "media_url" => "https://www.kreiger.com/non-sed-similique-dolores-deserunt-quia",
                "media_length" => "161656",
                "media_type" => "audio/mpeg",
                "image" => "https://lorempixel.com/640/480/?68816",
                "duration" => "02:30:42",
                "summary" => "Voluptnis. Consectetur voluptate odio harum quo ea.",
            ],
            "feed" =>  [
                "id" => 1,
                "name" => "sit rem amet",
                "url" => "https://www.altenwerth.com/nulla-assumenda-quia-aut-dolorem-impedit",
                "thumbnail_30" => "https://lorempixel.com/640/480/?72279",
                "thumbnail_60" => "https://lorempixel.com/640/480/?26416",
                "thumbnail_100" => "https://lorempixel.com/640/480/?20953",
                "thumbnail_600" => "https://lorempixel.com/640/480/?77870",
                "total_episodes" => "84",
                "last_episode_at" => "2018-06-30 12:28:09",
                "listeners" => "68",
                "slug" => "1-sit-rem-amet",
                "description" => "temporibus cupiditate quis sunt cupiditate",
                "color" => "#f2a107",
            ],
        ];

        $trasformer = app(UserFavoritesTransformer::class);

        $result = $trasformer->transform($input);

        $this->assertEquals($expectatedTransformed,$result);
    }
}
