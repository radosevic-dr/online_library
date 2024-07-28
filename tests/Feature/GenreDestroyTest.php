<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes a genre', function () {
    $genre = new Genre;
    $genre->name = 'Test Genre';
    $genre->save();

    $response = $this->deleteJson(route('genres.destroy', $genre->id));

    $response->assertStatus(200);
    $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
});
