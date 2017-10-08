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
        $this->post('v1/users/someuser/friends/anotheruser')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_404_when_trying_to_follow_nonexistent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();

        $this->post('v1/users/' . $user->username . '/friends/not-found-user')
            ->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_when_nonexistent_user_trying_to_follow_existent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();

        $this->post('v1/users/not-found-user/friends/' . $user->username)
            ->assertStatus(404);
    }

    /** @test */
    public function an_user_cannot_follow_twice_same_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $this->post('v1/users/' . $user->username . '/friends/' . $anotherUser->username)
            ->assertStatus(200);

        $this->post('v1/users/' . $user->username . '/friends/' . $anotherUser->username)
            ->assertStatus(400);

        $this->get('v1/users/' . $user->username . '/friends')
            ->assertStatus(200);

        $this->assertEquals(1, $user->fresh()->friends_count);
    }

    /** @test */
    public function an_user_can_follow_another_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $this->post('v1/users/' . $user->username . '/friends/' . $anotherUser->username)
            ->assertStatus(200);

        $this->get('v1/users/' . $user->username . '/friends')
            ->assertStatus(200);

        $this->assertEquals(1, $user->fresh()->friends_count);
    }
}
