<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a new genre', function () {
    $genreData = [
        'name' => 'Test Genre',
    ];

    $response = $this->postJson(route('genres.store'), $genreData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('genres', $genreData);
});
