<?php
namespace Tests\Integration\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_delete_user()
    {
        $this->delete('v1/users/username')
                ->assertResponseStatus(401);
    }
    
    /** @test */
    public function it_deletes_an_user()
    {
        $this->authenticate();
        
        $user = factory(User::class)->create();
        
        $this->delete('v1/users/' . $user->username)
            ->seeText(json_encode(['removed' => true]))
            ->assertResponseStatus(200);
        
        $this->get('v1/users/' . $user->username)
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function it_requires_a_valid_user()
    {
        $this->authenticate();
        
        factory(User::class, 3)->create();
        
        $this->delete('v1/users/not-valid-user')
            ->assertResponseStatus(404);
    }
}
