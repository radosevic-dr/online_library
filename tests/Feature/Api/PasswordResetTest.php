<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('resets the password with valid token', function () {
    $user = User::factory()->create([
        'email' => 'librarian@example.com',
    ]);

    $token = Password::createToken($user);

    $this->postJson('/api/password/reset', [
        'email' => $user->email,
        'token' => $token,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ])->assertStatus(200);

    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
});
