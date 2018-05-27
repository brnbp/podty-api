<?php

namespace Tests\Integration\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RetrieveUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_user()
    {
        $this->delete('v1/users/username')
                ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_an_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $this->get('v1/users/'.$user->username)
            ->assertExactJson([
                'data' => [
                    'id'             => $user->id,
                    'username'       => $user->username,
                    'email'          => $user->email,
                    'friends_count'  => $user->friends_count,
                    'podcasts_count' => $user->podcasts_count,
                    'joined_at'      => $user->created_at->toDateTimeString(),
                    'last_update'    => $user->updated_at->toDateTimeString(),
                ],
            ])
            //->seeJson()
            ->assertStatus(200);
    }

    /** @test */
    public function it_requires_a_valid_user()
    {
        $this->authenticate();

        $this->get('v1/users/not-valid-user')
            ->assertStatus(404);
    }
}
