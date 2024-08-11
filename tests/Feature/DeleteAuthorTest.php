<?php

use App\Models\Author;
use App\Models\User;
use function Pest\Laravel\delete;


it('can delete an author', function () {
    loginAsUser();

    $author = Author::factory()->create();

    $response = $this->delete('/api/authors/'.$author->id);

    $response->assertStatus(204);  // Expecting a 204 No Content response

    $this->assertDatabaseMissing('authors', ['id' => $author->id]);
});
