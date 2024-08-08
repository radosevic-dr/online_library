<?php

use App\Models\Author;
use App\Models\User;

use function Pest\Laravel\delete;

it('can delete an author', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $author = Author::factory()->create();

    $response = delete('/api/authors/'.$author->id, [], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Author deleted successfully']);

    $this->assertDatabaseMissing('authors', ['id' => $author->id]);
});
