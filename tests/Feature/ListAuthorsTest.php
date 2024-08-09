<?php

use App\Models\Author;
use App\Models\User;

use function Pest\Laravel\get;

it('can list authors with default pagination', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Author::factory()->count(25)->create();

    $response = get('/api/authors', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
        'links',
        'meta',
    ]);
});

it('can list authors with 50 per page', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Author::factory()->count(60)->create();

    $response = get('/api/authors?per_page=50', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
        'links',
        'meta',
    ]);

    $response->assertJsonCount(50, 'data');
});

it('can list authors with 100 per page', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Author::factory()->count(110)->create();

    $response = get('/api/authors?per_page=100', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
        'links',
        'meta',
    ]);

    $response->assertJsonCount(100, 'data');
});

it('defaults to 20 per page if invalid per_page is provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Author::factory()->count(25)->create();

    $response = get('/api/authors?per_page=30', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
        'links',
        'meta',
    ]);

    $response->assertJsonCount(20, 'data');
});
