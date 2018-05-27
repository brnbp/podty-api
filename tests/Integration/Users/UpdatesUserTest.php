<?php
namespace Tests\Integration\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdatesUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_update_an_user()
    {
        $this->put('v1/users/johndoe', [])
                ->assertStatus(401);
    }

    /** @test */
    public function it_requires_an_valid_user()
    {
        $this->authenticate();

        factory(User::class)->create([
            'username' => 'otheruser',
            'password' => 'old-password'
        ]);

        $this->put('v1/users/johndoe', [
            'password' =>  'new-password'
        ])->assertStatus(404);
    }

    /** @test */
    public function it_updates_an_user_password()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'password' => 'old-password'
        ]);

        $this->put('v1/users/johndoe', [
            'password' =>  'new-password'
        ])->assertStatus(200);

        $this->assertSame('new-password', $user->fresh()->password);
    }

    /** @test */
    public function a_user_requires_a_minimum_length_password()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'password' => 'old-but-good-password'
        ]);

        $this->put( 'v1/users/johndoe', [
            'password' => 'new'
        ])->assertJsonFragment(['password' => ['The password must be at least 5 characters.']])
            ->assertStatus(422);

        $this->assertSame('old-but-good-password', $user->fresh()->password);
    }

    /** @test */
    public function it_updates_an_user_username()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'old-jondoe',
            'password' => 'keep-this-password'
        ]);

        $this->put('v1/users/old-jondoe', [
            'username' =>  'johndoe',
        ])->assertStatus(200);

        $user = $user->fresh();

        $this->assertSame('johndoe', $user->username);
        $this->assertSame('keep-this-password', $user->password);
    }

    /** @test */
    public function it_requires_an_unique_username_when_updating_username()
    {
        $this->authenticate();

        factory(User::class)->create([
            'username' => 'johndoe',
        ]);

        $user = factory(User::class)->create([
            'username' => 'johannes',
        ]);

        $this->put('v1/users/johannes', [
            'username' =>  'johndoe',
        ])->assertJsonFragment(['username' => ['The username has already been taken.']])
            ->assertStatus(422);

        $this->assertSame('johannes', $user->fresh()->username);
    }

    /** @test */
    public function it_requires_a_valid_email_for_update()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'email' => 'valid@email.com'
        ]);

        $this->put( 'v1/users/johndoe', [
            'email' => 'not@valid-email'
        ])->assertJsonFragment(['email' => ['The email must be a valid email address.']])
            ->assertStatus(422);

        $this->assertSame('valid@email.com', $user->fresh()->email);
    }

    /** @test */
    public function it_requires_an_unique_email_for_update()
    {
        $this->authenticate();

        factory(User::class)->create([
            'email' => 'really@unique.email',
        ]);

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'email' => 'email@server.com',
        ]);

        $this->put('v1/users/johndoe', [
            'email' =>  'really@unique.email',
        ])->assertJsonFragment(['email' => ['The email has already been taken.']])
            ->assertStatus(422);

        $this->assertSame('email@server.com', $user->fresh()->email);
    }

    /** @test */
    public function it_updates_an_user_email()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'email' => 'old@email.com',
        ]);

        $this->put('v1/users/johndoe', [
            'email' => 'new@email.com',
        ])->assertStatus(200);

        $this->assertSame('new@email.com', $user->fresh()->email);
    }

    /** @test */
    public function it_should_update_fields_when_already_existent_if_belongs_to_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'johndoe',
            'email' => 'john@doe.com',
        ]);

        $this->put('v1/users/johndoe', [
            'username' => 'johndoe',
            'email' => 'john@doe.com',
        ])->assertStatus(200);

        $this->assertSame('johndoe', $user->fresh()->username);
        $this->assertSame('john@doe.com', $user->fresh()->email);
    }
}
