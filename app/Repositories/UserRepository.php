<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function create($userData)
    {
        $user = new User([
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => User::encryptPassword($userData['password']),
        ]);

        $user->save();
        
        return $user;
    }

    public static function getFirst($username)
    {
        return User::whereUsername($username)->first();
    }
}
