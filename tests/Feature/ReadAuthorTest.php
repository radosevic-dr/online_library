<?php

use App\Models\Author;
use App\Models\User;
use function Pest\Laravel\get;

it('can retrieve an author', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $author = Author::factory()->create();

    $response = get('/api/authors/' . $author->id, [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $author->id,
        'first_name' => $author->first_name,
        'last_name' => $author->last_name,
        'biography' => $author->biography,
    ]);
});
