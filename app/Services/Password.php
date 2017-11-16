<?php
namespace App\Services;

class Password
{
    public static function encrypt($password)
    {
        return bcrypt($password);
    }
}
