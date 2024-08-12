<?php

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('lists all genres', function () {
    for ($i = 0; $i < 10; $i++) {
        $genre = new Genre;
        $genre->name = 'Test Genre '.$i;
        $genre->save();
    }

    $librarian = User::factory()->create([
        'email' => 'librarian@library.com',
        'password' => Hash::make('12345678'),
        'user_type' => User::USER_TYPE_LIBRARIAN,
    ]);

    loginAsUser($librarian);

    if ($librarian->user_type !== User::USER_TYPE_LIBRARIAN) {
        throw new Exception('User is not a librarian');
    }

    $response = $this->getJson(route('genres.index'));

    $response->assertStatus(200);
    $response->assertJsonCount(10, 'data');
});
