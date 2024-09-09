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

it('can list categories with default pagination', function () {
    loginAsUser();

    Category::factory()->count(25)->create();

    $response = $this->getJson('/api/categories');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name', 'description', 'icon'],
        ],
        'links',
        'meta',
    ]);
});

it('can list categories with 50 per page', function () {
    loginAsUser();

    Category::factory()->count(60)->create();

    $response = $this->getJson('/api/categories?per_page=50');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name', 'description', 'icon'],
        ],
        'links',
        'meta',
    ]);

    $response->assertJsonCount(50, 'data');
});

it('can search categories by name or description', function () {
    loginAsUser();

    Category::factory()->create(['name' => 'Fiction', 'description' => 'Books of fiction']);
    Category::factory()->create(['name' => 'Science', 'description' => 'Science related books']);

    $response = $this->getJson('/api/categories?search=Fiction');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonPath('data.0.name', 'Fiction');
});

it('can view category details', function () {
    loginAsUser();

    $category = Category::factory()->create([
        'name' => 'Novels',
        'description' => 'A collection of novels.',
    ]);

    $response = $this->get('/api/categories/'.$category->id);

    $response->assertStatus(200);
    $response->assertJson([
        'name' => 'Novels',
        'description' => 'A collection of novels.',
    ]);
});

it('can return category icon', function () {
    Storage::fake('public');

    loginAsUser();

    $category = Category::factory()->create([
        'name' => 'Novels',
        'description' => 'A collection of novels.',
        'icon' => 'icons/icon.png',
    ]);

    Storage::disk('public')->put('icons/icon.png', 'icon-content');

    $response = $this->get('/api/categories/'.$category->id.'/icon');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'image/png');
});

