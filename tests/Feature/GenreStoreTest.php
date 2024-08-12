<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('creates a new genre', function () {
    $genreData = [
        'name' => 'Test Genre',
    ];

    $librarian = User::factory()->create([
        'email' => 'librarian@library.com',
        'password' => Hash::make('12345678'),
        'user_type' => User::USER_TYPE_LIBRARIAN,
    ]);

    loginAsUser($librarian);

    if ($librarian->user_type !== User::USER_TYPE_LIBRARIAN) {
        throw new Exception('User is not a librarian');
    }

    $response = $this->postJson(route('genres.store'), $genreData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('genres', $genreData);
});
