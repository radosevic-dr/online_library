<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('sends a password reset link', function () {
    $user = User::factory()->create([
        'email' => 'librarian@example.com',
    ]);

    $this->postJson('/api/password/email', [
        'email' => $user->email,
    ])->assertStatus(200);
});
