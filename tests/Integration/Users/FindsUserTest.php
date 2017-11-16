<?php
namespace Tests\Integration\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FindsUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_search_user()
    {
        $this->get('v1/users/find/randomuser')
                ->assertStatus(401);
    }

    /** @test */
    public function it_searches_for_a_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create([
            'username' => 'specificUser'
        ]);

        factory(User::class, 2)->create();

        $this->get('v1/users/find/specificUser')
            ->assertExactJson([
                'meta' => [
                    'total_matches' => 1
                ],
                'data' => [
                    [
                        "id" => $user->id,
                        "username" => 'specificUser',
                        "friends_count" => (string) $user->friends_count,
                        "podcasts_count" => (string) $user->podcasts_count
                    ]
                ]
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_searches_for_a_not_found_user()
    {
        $this->authenticate();

        factory(User::class, 2)->create();

        $this->get('v1/users/find/specificUser')
            ->assertExactJson([
                'error' => [
                    'message' => 'Not Found',
                    'status_code' => 404,
                ]
            ])
            ->assertStatus(404);
    }
}
