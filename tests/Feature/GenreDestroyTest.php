<?php

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('deletes a genre', function () {
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

    $response = $this->deleteJson(route('genres.destroy', $genre->id));

    $response->assertStatus(200);
    $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
});
