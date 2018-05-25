<?php
namespace Tests\Integration\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticateUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_authenticates_an_existent_user()
    {
        $this->authenticate();

        factory(User::class)->create([
            'username' => 'johndoe',
            'password' => Hash::make('siper-sicret-password'),
        ]);

        $this->post('v1/users/authenticate', [
            'username' => 'johndoe',
            'password' => 'siper-sicret-password',
        ])->assertStatus(200);
    }

    /** @test */
    public function it_cannot_authenticate_user_with_wrong_password()
    {
        $this->authenticate();

        factory(User::class)->create([
            'username' => 'johndoe',
            'password' => Hash::make('siper-sicret-password'),
        ]);

        $this->post('v1/users/authenticate', [
            'username' => 'johndoe',
            'password' => 'super-secret-password',
        ])->assertStatus(401);
    }
}
