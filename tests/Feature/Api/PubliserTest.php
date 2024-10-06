<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('creates a new publisher', function () {
    Storage::fake('public');

    $data = [
        'name' => 'New Publisher',
        'logo' => UploadedFile::fake()->image('logo.jpg'),
        'address' => '123 Main St',
        'website' => 'https://publisher.com',
        'established_year' => 2022,
        'email' => 'publisher@publisher.com',
        'phone' => '1234567890',
    ];

    $response = loginAsUser()->post(route('publishers.create'), $data);

    $response->assertStatus(201);
    $this->assertDatabaseHas('publishers', ['name' => 'New Publisher', 'email' => 'publisher@publisher.com']);
});
