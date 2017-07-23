<?php
namespace Tests\Integration\Users;

use App\Models\Customer;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_create_user()
    {
        $user = factory(User::class)->make();

        $this->post('v1/users', $user->toArray())
                ->assertResponseStatus(401);
    }
    
    /** @test */
    public function it_creates_an_user()
    {
        $this->authenticate();
        
        $user = factory(User::class)->make();
        
        $this->post('v1/users', $user->toArray())
            ->seeText($user->username)
            ->seeText($user->email)
            ->assertResponseStatus(200);
    }
    
    /** @test */
    public function a_user_requires_a_username()
    {
        $this->authenticate();
        
        $user = factory(User::class)->make([
           'username' => null
        ]);
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The username field is required.')
            ->assertResponseStatus(400);
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
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The username has already been taken.')
            ->assertResponseStatus(400);
    }
    
    /** @test */
    public function a_user_requires_a_minimum_length_username()
    {
        $this->authenticate();
    
        $user = factory(User::class)->make([
            'username' => 'fo'
        ]);
    
        $this->post('v1/users', $user->toArray())
            ->seeText('The username must be at least 3 characters.')
            ->assertResponseStatus(400);
    }
    
    /** @test */
    public function a_user_requires_a_maximum_length_username()
    {
        $this->authenticate();
        
        $user = factory(User::class)->make([
            'username' => 'reallyreallylongusername'
        ]);
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The username may not be greater than 20 characters.')
            ->assertResponseStatus(400);
    }
    
    /** @test */
    public function a_user_requires_a_email()
    {
        $this->authenticate();
        
        $user = factory(User::class)->make([
           'email' => null
        ]);
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The email field is required.')
            ->assertResponseStatus(400);
    }
    
    /** @test */
    public function a_user_requires_a_valid_email()
    {
        $this->authenticate();
        
        $user = factory(User::class)->make([
            'email' => 'not-valid-email'
        ]);
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The email must be a valid email address.')
            ->assertResponseStatus(400);
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
        
        $this->post('v1/users', $user->toArray())
            ->seeText('The email has already been taken.')
            ->assertResponseStatus(400);
    }
    
    /** @test */
    public function a_user_requires_a_minimum_length_password()
    {
        $this->authenticate();
    
        $user = factory(User::class)->make([
            'password' => 'foo'
        ]);
    
        $this->post('v1/users', $user->toArray())
            ->seeText('The password must be at least 5 characters.')
            ->assertResponseStatus(400);
    }
}
