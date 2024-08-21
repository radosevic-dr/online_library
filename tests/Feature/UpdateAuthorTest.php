<?php

use App\Models\Author;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can update an author', function () {
    Storage::fake('public');

    loginAsUser();

    $author = Author::factory()->create();

    $file = UploadedFile::fake()->image('updated_picture.jpg');

    $response = $this->postJson('/api/authors/'.$author->id, [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'biography' => 'An updated bio',
        'picture' => $file,
    ]);

    $response->assertStatus(200);

    $response->assertJson([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'biography' => 'An updated bio',
    ]);

    Storage::disk('public')->assertExists($response["media"][0]["id"] . "/" . $response["media"][0]["file_name"]);
});
