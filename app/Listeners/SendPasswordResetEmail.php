<?php

namespace App\Listeners;

use App\Events\LibrarianCreated;
use Illuminate\Support\Facades\Password;

class SendPasswordResetEmail
{
    public function handle(LibrarianCreated $event)
    {
        $token = Password::createToken($event->user);
        $url = route('password.reset', ['token' => $token, 'email' => $event->user->email]);

        // Send the password reset email with the generated token
        $event->user->sendPasswordResetNotification($token);
    }
}
