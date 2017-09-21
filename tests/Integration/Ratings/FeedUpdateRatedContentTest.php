<?php
namespace Tests\Integration\Ratings;

use App\Models\Feed;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FeedUpdateRatedContentTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_requires_authentication_to_rate_content()
    {
        $feed = factory(Feed::class)->create();
        $this->post('/v1/feeds/' . $feed->id . '/rating')
            ->seeStatusCode(401);
    }
    
    /** @test */
    public function it_rate_an_content()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $user = factory(User::class, 2)->create()->last();
        
        $faker = Factory::create();
        $rate = $faker->randomFloat(2, 0.00 , 5.00);
        
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => $rate,
            'user' => $user->id
        ])->seeStatusCode(201)
          ->seeJson([
              "data" => [
                  "id" => 1,
                  "user_id" => $user->id,
                  "content_id" => $feed->id,
                  "content_type" => 'App\Models\Feed',
                  "rate" => $rate,
              ]
          ]);
    }
    
    /** @test */
    public function it_requires_valid_rate_value()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $user = factory(User::class)->create();
        
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => 5.01,
            'user' => $user->id
        ])->seeStatusCode(422)
          ->seeJson([
              "rate" => [
                  'The rate must be between 0.00 and 5.00 float digits.'
              ]
          ]);
    
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => -1.01,
            'user' => $user->id
        ])->seeStatusCode(422)
            ->seeJson([
                "rate" => [
                    'The rate must be between 0.00 and 5.00 float digits.'
                ]
            ]);
    
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => 'not-numeric-value',
            'user' => $user->id
        ])->seeStatusCode(422)
            ->seeJson([
                "rate" => [
                    'The rate must be between 0.00 and 5.00 float digits.'
                ]
            ]);
    }
    
    /** @test */
    public function it_requires_an_rate_value()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $user = factory(User::class)->create();
        
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'user' => $user->id
        ])->seeStatusCode(422)
            ->seeJson([
                "rate" => [
                    'The rate field is required.'
                ]
            ]);
    }
    
    /** @test */
    public function it_requires_an_user()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();
        
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => 4
        ])->seeStatusCode(422)
            ->seeJson([
                "user" => [
                    'The user field is required.'
                ]
            ]);
    }
    
    /** @test */
    public function it_requires_an_valid_user()
    {
        $this->authenticate();
        
        $feed = factory(Feed::class)->create();

        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => 4,
            'user' => 1
        ])->seeStatusCode(422)
            ->seeJson([
                "user" => [
                    'The selected user is invalid.'
                ]
            ]);
    }
    
    /** @test */
    public function it_allows_to_rate_an_content_only_one_time()
    {
        $this->authenticate();
    
        $feed = factory(Feed::class)->create();
    
        $user = factory(User::class, 2)->create()->last();
    
        $faker = Factory::create();
        $rate = $faker->randomFloat(2, 0.00 , 5.00);
    
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => $rate,
            'user' => $user->id
        ])->seeStatusCode(201)
            ->seeJson([
                "data" => [
                    "id" => 1,
                    "user_id" => $user->id,
                    "content_id" => $feed->id,
                    "content_type" => 'App\Models\Feed',
                    "rate" => $rate,
                ]
            ]);
    
        $this->json('post', '/v1/feeds/' . $feed->id . '/rating', [
            'rate' => $rate,
            'user' => $user->id
        ])->seeStatusCode(422)
            ->seeJson([
                'error' => [
                    'message' => 'User already rated this content',
                    'status_code' => 422
                ]
            ]);
    }
}
