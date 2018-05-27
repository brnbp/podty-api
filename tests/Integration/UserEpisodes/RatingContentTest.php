<?php

namespace Tests\Integration\UserEpisodes;

use App\Models\Episode;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RatingContentTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_requires_authentication_to_rate_content()
    {
        $episode = factory(Episode::class)->create();
        $user = factory(User::class)->create();

        $this->post('/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate')
            ->assertStatus(401);
    }

    /** @test */
    public function it_rate_an_content()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $user = factory(User::class, 2)->create()->last();

        $faker = Factory::create();
        $rate = $faker->randomFloat(2, 0.00, 5.00);

        $this->json('post',
            '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => $rate,
        ])->assertStatus(201)
          ->assertJson([
              'data' => [
                  'id'           => 1,
                  'user_id'      => $user->id,
                  'content_id'   => $episode->id,
                  'content_type' => 'App\Models\Episode',
                  'rate'         => $rate,
              ],
          ]);
    }

    /** @test */
    public function it_requires_valid_rate_value()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $user = factory(User::class)->create();

        $this->json('post',
            '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => 5.01,
        ])->assertStatus(422)
          ->assertJson([
              'message' => 'The given data was invalid.',
              'errors'  => [
                  'rate' => [
                      'The rate must be between 0.00 and 5.00 float digits.',
                  ],
              ],
          ]);

        $this->json('post',
            '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => -1.01,
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'rate' => [
                        'The rate must be between 0.00 and 5.00 float digits.',
                    ],
                ],
            ]);

        $this->json('post',
            '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => 'not-numeric-value',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'rate' => [
                        'The rate must be between 0.00 and 5.00 float digits.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_requires_an_rate_value()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $user = factory(User::class)->create();

        $this->json('post', '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'rate' => [
                        'The rate field is required.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_requires_an_valid_user()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();

        $this->json('post', '/v1/users/random-user/episodes/'.$episode->id.'/rate', [
            'rate' => 4,
        ])->assertStatus(404);
    }

    /** @test */
    public function it_updates_an_rated_content()
    {
        $this->authenticate();

        $episode = factory(Episode::class)->create();
        $user = factory(User::class, 2)->create()->last();

        $this->json('post', '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => 5.0,
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id'           => 1,
                    'user_id'      => $user->id,
                    'content_id'   => $episode->id,
                    'content_type' => 'App\Models\Episode',
                    'rate'         => 5.0,
                ],
            ]);

        $this->json('post', '/v1/users/'.$user->username.'/episodes/'.$episode->id.'/rate', [
            'rate' => 3.1,
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'           => 1,
                    'user_id'      => "$user->id",
                    'content_id'   => "$episode->id",
                    'content_type' => 'App\Models\Episode',
                    'rate'         => 3.1,
                ],
            ]);
    }
}
