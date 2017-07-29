<?php
namespace Tests\Integration\UserFriends;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FollowUsersTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function unauthenticated_client_cannot_follow_users()
    {
        $user = factory(User::class)->create();
        $friend = factory(User::class)->create();
        
        
        $this->post('v1/users/' . $user->username . '/friends/' . $friend->username)
            ->assertResponseStatus(401);
    }
    
    /** @test */
    public function it_returns_404_when_trying_to_follow_nonexistent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $this->post('v1/users/' . $user->username . '/friends/not-found-user')
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function it_returns_404_when_nonexistent_user_trying_to_follow_existent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        
        $this->post('v1/users/not-found-user/friends/' . $user->username)
            ->assertResponseStatus(404);
    }
    
    /** @test */
    public function an_user_can_follow_another_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();
        
        $this->post('v1/users/' . $user->username . '/friends/' . $anotherUser->username)
            ->assertResponseStatus(200);
    
        $this->get('v1/users/' . $user->username . '/friends')
            ->assertResponseStatus(200);
        
        $this->assertEquals(1, $user->fresh()->friends_count);
    }
}
