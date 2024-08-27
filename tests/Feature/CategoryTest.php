<?php

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can create a category', function () {
    loginAsUser();

    $response = $this->postJson('/api/category', [
        'name' => 'Novels',
        'description' => 'A collection of novels.',
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'name' => 'Novels',
        'description' => 'A collection of novels.',
    ]);

    $category = Category::where('name', 'Novels')->first();
    expect($category)->not->toBeNull();
});

it('can upload an icon for a category', function () {
    Storage::fake('public');

    loginAsUser();

    $category = Category::factory()->create([
        'name' => 'Novels',
        'description' => 'A collection of novels.',
    ]);

    $file = UploadedFile::fake()->image('icon.png');

    $response = $this->post('/api/upload-icon/'.$category->id, [
        'icon' => $file,
    ]);

    $response->assertStatus(200);

    Storage::disk('public')->assertExists('icons/'.$file->hashName());

    $category->refresh();
    expect($category->icon)->toBe('icons/'.$file->hashName());
});

it('can delete a category and its icon', function () {
    Storage::fake('public');

    loginAsUser();

    $category = Category::factory()->create([
        'icon' => 'icons/icon.png',
    ]);

    Storage::disk('public')->put('icons/icon.png', 'icon-content');

    $response = $this->deleteJson('/api/categories/' . $category->id);

    
    $response->assertStatus(204);

   
    Storage::disk('public')->assertMissing('icons/icon.png');

    
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
