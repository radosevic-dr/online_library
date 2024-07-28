<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('views a genre', function () {
    $genre = new Genre;
    $genre->name = 'Test Genre';
    $genre->save();

    $response = $this->getJson(route('genres.show', $genre->id));

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $genre->id,
        'name' => $genre->name,
    ]);
});
