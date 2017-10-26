<?php
namespace Tests\Integration\UserFriends;

use App\Models\User;
use App\Repositories\UserFriendsRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveFriendsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_friends()
    {
        $this->get('v1/users/someuser/friends')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_friends_from_given_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create();
        $friends = factory(User::class, 2)->create();

        $friends->each(function ($friend) use ($user) {
            UserFriendsRepository::follow($user->id, $friend->id);
        });

        $this->get('v1/users/' . $user->username . '/friends')
            ->assertExactJson([
                'data' => [
                    [
                      "id" => $friends->first()->id,
                      "username" => $friends->first()->username,
                      "email" => $friends->first()->email,
                      "friends_count" => $friends->first()->friends_count,
                      "podcasts_count" => $friends->first()->podcasts_count,
                      "joined_at" => $friends->first()->created_at->toDateTimeString(),
                      "last_update" => $friends->first()->updated_at->toDateTimeString(),
                    ],
                    [
                        "id" => $friends->last()->id,
                        "username" => $friends->last()->username,
                        "email" => $friends->last()->email,
                        "friends_count" => $friends->last()->friends_count,
                        "podcasts_count" => $friends->last()->podcasts_count,
                        "joined_at" => $friends->last()->created_at->toDateTimeString(),
                        "last_update" => $friends->last()->updated_at->toDateTimeString(),
                    ]
                ]
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_retrieves_zero_friends_from_given_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $this->get('v1/users/' . $user->username . '/friends')
            ->assertExactJson([
                'error' => [
                    'message' => 'Not Found',
                    'status_code' => 404
                ]
            ])
            ->assertStatus(404);
    }
}
