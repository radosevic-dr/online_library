<?php

namespace App\Listeners;

use App\Events\LibrarianCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\LibraryEmail;

class SendPasswordResetEmail
{
    /**
     * Handle the event.
     */
    public function handle(LibrarianCreated $event): void
    {
        $user = $event->user;

        // Send the email using the correct Mailable class
        Mail::to($user->email)->send(new LibraryEmail($user->name));
    }
}
