<?php

use App\Models\Author;
use function Pest\Laravel\delete;

it('can delete an author', function () {
    $author = Author::factory()->create();

    $response = delete('/api/authors/' . $author->id);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Author deleted successfully']);

    $this->assertDatabaseMissing('authors', ['id' => $author->id]);
});
