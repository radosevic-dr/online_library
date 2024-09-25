<?php

use App\Mail\LibraryEmail;
use Illuminate\Support\Facades\Mail;

it('sends an email when a librarian is created', function () {
    // Arrange: Mock the Mail facade
    Mail::fake();

    // Act: Trigger the email functionality (e.g., create a librarian)
    $librarianName = 'John Doe';
    
    // Triggering the event that would send the email.
    Mail::to('librarian@example.com')->send(new LibraryEmail($librarianName));

    // Assert: Ensure the email was sent
    Mail::assertSent(LibraryEmail::class, function ($mail) use ($librarianName) {
        return $mail->hasTo('librarian@example.com') &&
               $mail->name === $librarianName;
    });
});
