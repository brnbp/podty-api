<?php

namespace Tests\Integration\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TouchUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_touch_user()
    {
        $this->patch('v1/users/username/touch')
                ->assertStatus(401);
    }

    /** @test */
    public function it_touches_a_user()
    {
        $this->authenticate();

        $user = factory(User::class)->create();

        $this->patch('v1/users/'.$user->username.'/touch')
            ->assertStatus(200);
    }

    /** @test */
    public function it_requires_a_valid_user()
    {
        $this->authenticate();

        $this->patch('v1/users/not-valid-user/touch')
            ->assertStatus(404);
    }
}
