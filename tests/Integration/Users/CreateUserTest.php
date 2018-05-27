<?php
namespace Tests\Integration\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_create_user()
    {
        $this->post('v1/users', [])
                ->assertStatus(401);
    }

    /** @test */
    public function it_creates_an_user()
    {
        $this->authenticate();

        $user = factory(User::class)->make();

        $this->post('v1/users', $user->toArray())
            ->assertJsonFragment([$user->username])
            ->assertJsonFragment([$user->email])
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_requires_a_username()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
           'username' => null
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The username field is required.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_unique_username()
    {
        $this->authenticate();

        factory(User::class)->create([
            'username' => 'reallyunique'
        ]);

        $user = factory(User::class)->make([
            'username' => 'reallyunique'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The username has already been taken.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_minimum_length_username()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
            'username' => 'fo'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The username must be at least 3 characters.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_maximum_length_username()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
            'username' => 'reallyreallylongusername'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The username may not be greater than 20 characters.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_email()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
           'email' => null
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The email field is required.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_valid_email()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
            'email' => 'not-valid-email'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The email must be a valid email address.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_unique_email()
    {
        $this->authenticate();

        factory(User::class)->create([
            'email' => 'totally@valid.email'
        ]);

        $user = factory(User::class)->make([
            'email' => 'totally@valid.email'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The email has already been taken.'])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_requires_a_minimum_length_password()
    {
        $this->authenticate();

        $user = factory(User::class)->make([
            'password' => 'foo'
        ]);

        $this->json('post', 'v1/users', $user->toArray())
            ->assertJsonFragment(['The password must be at least 5 characters.'])
            ->assertStatus(422);
    }
}
