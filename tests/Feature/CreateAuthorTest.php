<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\postJson;

it('can create an author', function () {
    Storage::fake('public');

    loginAsUser();

    $file = UploadedFile::fake()->image('avatar.jpg');

    $response = $this->postJson('/api/authors', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'biography' => 'A short bio',
        'picture' => $file,
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id', 'first_name', 'last_name', 'biography', 'created_at', 'updated_at', 'media',
    ]);

    Storage::disk('public')->assertExists($response["id"]."/".$response["media"][0]["file_name"]);
});
