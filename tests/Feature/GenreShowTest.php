<?php

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('views a genre', function () {
    $genre = new Genre;
    $genre->name = 'Test Genre';
    $genre->save();

    $librarian = User::factory()->create([
        'email' => 'librarian@library.com',
        'password' => Hash::make('12345678'),
        'user_type' => User::USER_TYPE_LIBRARIAN,
    ]);

    loginAsUser($librarian);

    if ($librarian->user_type !== User::USER_TYPE_LIBRARIAN) {
        throw new Exception('User is not a librarian');
    }

    $response = $this->getJson(route('genres.show', $genre->id));

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $genre->id,
        'name' => $genre->name,
    ]);
});
