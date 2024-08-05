<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists all genres', function () {
    for ($i = 0; $i < 10; $i++) {
        $genre = new Genre;
        $genre->name = 'Test Genre '.$i;
        $genre->save();
    }

    $response = $this->getJson(route('genres.index'));

    $response->assertStatus(200);
    $response->assertJsonCount(10, 'data');
});
