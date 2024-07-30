<?php

use App\Models\Author;
use function Pest\Laravel\get;

it('can list authors', function () {
    Author::factory()->count(25)->create();

    $response = get('/api/authors?per_page=20');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
        'links',
        'meta',
    ]);
});
