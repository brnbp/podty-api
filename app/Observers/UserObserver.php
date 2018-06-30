<?php
namespace App\Observer;

use App\Mail\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    public function created(User $user)
    {
        Mail::send(new UserRegistered($user));
    }
}
