<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\Password;

class UserRepository
{
    public static function create($userData)
    {
        $user = new User([
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => Password::encrypt($userData['password']),
        ]);

        $user->save();

        return $user;
    }

    public static function verifyAuthentication($userData)
    {
        $user = User::whereUsername($userData['username'])
                    ->wherePassword($userData['password'])
                    ->get();

        return $user->count();
    }

    public static function getFirst($username)
    {
        return User::whereUsername($username)->first();
    }
}
