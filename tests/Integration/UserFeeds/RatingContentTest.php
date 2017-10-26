<?php
namespace Tests\Integration\UserFeeds;

use App\Models\Feed;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RatingContentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var User $user
     */
    public $user;

    /**
     * @var Feed $feed
     */
    public $feed;

    public function setUp()
    {
        parent::setUp();

        $this->user = create(User::class);
        $this->feed = create(Feed::class);
    }

    /** @test */
    public function it_requires_authentication_to_rate_content()
    {
        $this->post('/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate')
            ->assertStatus(401);
    }

    /** @test */
    public function it_rate_an_content()
    {
        $this->authenticate();

        $faker = Factory::create();
        $rate = $faker->randomFloat(2, 0.00, 5.00);

        $this->json('post',
            '/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate', [
            'rate' => $rate,
        ])->assertStatus(201)
          ->assertExactJson([
              "data" => [
                  "id" => 1,
                  "user_id" => $this->user->id,
                  "content_id" => $this->feed->id,
                  "content_type" => 'App\Models\Feed',
                  "rate" => $rate,
              ]
          ]);
    }

    /**
     * @test
     * @dataProvider getRatings()
     */
    public function it_requires_valid_rate_value($rate)
    {
        $this->authenticate();

        $this->json('post',
            '/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate', [
            'rate' => $rate,
        ])->assertStatus(422)
          ->assertExactJson([
              'message' => 'The given data was invalid.',
              'errors' => [
                  "rate" => [
                      'The rate must be between 0.00 and 5.00 float digits.'
                  ]
              ]
          ]);
    }

    /** @test */
    public function it_requires_an_rate_value()
    {
        $this->authenticate();

        $this->json('post', '/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    "rate" => [
                        'The rate field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_requires_an_valid_user()
    {
        $this->authenticate();

        $this->json('post', '/v1/users/random-user/feeds/' . $this->feed->id . '/rate', [
            'rate' => 4,
        ])->assertStatus(404);
    }

    /** @test */
    public function it_updates_an_rated_content()
    {
        $this->authenticate();

        $this->json('post', '/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate', [
            'rate' => 5.0,
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "user_id" => $this->user->id,
                    "content_id" => $this->feed->id,
                    "content_type" => 'App\Models\Feed',
                    "rate" => 5.0,
                ]
            ]);

        $this->json('post', '/v1/users/' . $this->user->username . '/feeds/' . $this->feed->id . '/rate', [
            'rate' => 3.1,
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "user_id" => "{$this->user->id}",
                    "content_id" => "{$this->feed->id}",
                    "content_type" => 'App\Models\Feed',
                    "rate" => 3.1,
                ]
            ]);
    }

    public function getRatings()
    {
        return [
          [5.01],
          [-1.01],
          ['not-numeric-value'],
        ];
    }
}
