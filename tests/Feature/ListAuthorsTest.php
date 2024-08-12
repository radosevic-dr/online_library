<?php

use App\Models\Author;
use function Pest\Laravel\get;

it('can list authors with default pagination', function () {
    
    loginAsUser();

    Author::factory()->count(25)->create();

    $response = $this->get('/api/authors');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
    ]);
});

it('can list authors with 50 per page', function () {
    
    loginAsUser();

    Author::factory()->count(60)->create();

    $response = $this->get('/api/authors?per_page=50');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
    ]);

    $response->assertJsonCount(50, 'data');
});

it('can list authors with 100 per page', function () {
   
    loginAsUser();

    Author::factory()->count(110)->create();

    $response = $this->get('/api/authors?per_page=100');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
    ]);

    $response->assertJsonCount(100, 'data');
});

it('defaults to 20 per page if invalid per_page is provided', function () {
    loginAsUser();

    Author::factory()->count(25)->create();

    $response = $this->followingRedirects()->get('/api/authors?per_page=25'); 

    $response->assertStatus(200); 
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at'],
        ],
    ]);

    $response->assertJsonCount(20, 'data');
});


it('can search authors by first or last name', function () {
    loginAsUser();

    Author::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    Author::factory()->create(['first_name' => 'Jane', 'last_name' => 'Smith']);

    $response = $this->get('/api/authors?search=John');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonPath('data.0.first_name', 'John');
});
