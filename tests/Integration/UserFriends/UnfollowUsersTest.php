<?php

namespace Tests\Integration\UserFriends;

use App\Models\User;
use App\Repositories\UserFriendsRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UnfollowUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_follow_users()
    {
        $this->delete('v1/users/someuser/friends/anotheruser')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_404_when_trying_to_unfollow_nonexistent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();

        $this->delete('v1/users/'.$user->username.'/friends/not-found-user')
            ->assertStatus(404);
    }

    /** @test */
    public function it_returns_404_when_nonexistent_user_trying_to_unfollow_existent_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();

        $this->delete('v1/users/not-found-user/friends/'.$user->username)
            ->assertStatus(404);
    }

    /** @test */
    public function an_user_cannot_unfollow_user_which_is_not_friend()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $friend = factory(User::class)->create();

        $this->delete('v1/users/'.$user->username.'/friends/'.$friend->username)
            ->assertStatus(400);

        $this->get('v1/users/'.$user->username.'/friends')
            ->assertStatus(404);

        $this->assertEquals(0, $user->fresh()->friends_count);
    }

    /** @test */
    public function an_user_can_unfollow_another_user()
    {
        $this->authenticate();
        $user = factory(User::class)->create();
        $friend = factory(User::class)->create();

        UserFriendsRepository::follow($user->id, $friend->id);
        UserRepository::incrementsFriendsCount($user->id);

        $this->delete('v1/users/'.$user->username.'/friends/'.$friend->username)
            ->assertStatus(200);

        $this->get('v1/users/'.$user->username.'/friends')
            ->assertStatus(404);

        $this->assertEquals(0, $user->fresh()->friends_count);
    }
}
