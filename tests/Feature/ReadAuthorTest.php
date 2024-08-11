<?php

use App\Models\Author;
use App\Models\User;

use function Pest\Laravel\get;

it('can retrieve an author', function () {
    
    loginAsUser();

    $author = Author::factory()->create();

    $response = $this->get('/api/authors/'.$author->id);

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $author->id,
        'first_name' => $author->first_name,
        'last_name' => $author->last_name,
        'biography' => $author->biography,
    ]);
});
