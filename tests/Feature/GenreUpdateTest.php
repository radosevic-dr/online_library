<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates a genre', function () {
    $genre = new Genre;
    $genre->name = 'Test Genre';
    $genre->save();

    $updatedGenreData = [
        'name' => 'Updated Genre',
    ];

    $response = $this->putJson(route('genres.update', $genre->id), $updatedGenreData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('genres', $updatedGenreData);
});
