<?php

use App\Models\Author;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\putJson;

it('can update an author', function () {
    Storage::fake('public');

    $author = Author::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');

    $response = putJson('/api/authors/' . $author->id, [
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

    Storage::disk('public')->assertExists('pictures/' . $file->hashName());
});
