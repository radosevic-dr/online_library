<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Foundation\Testing\RefreshDatabase;

/* ---------- login user test ----------*/

it('can login existing user', function () {
    $user = User::factory()->create([
        'email' => 'librarian@library.com',
        'password' => Hash::make('12345678'),
    ]);

    $response = $this->postJson(route('user.login'), [
        'email' => 'librarian@library.com',
        'password' => '12345678',
    ]);

    $response->assertStatus(200);

    $this->assertAuthenticated();
});

/* ---------- register user test ----------*/

it('can register new user', function () {
    loginAsUser()->post(route('user.register'), [User::factory()->create()])->assertRedirect('/');

    $newUser = User::latest()->first();

    expect($newUser->name)->toBeString();
});

/* ---------- edit user test ----------*/
it('can edit user', function () {
    loginAsUser();
    $response = $this->putJson(route('user.edit'), [
        'name' => 'New Name',
        'email' => 'new_mail@librarian.com',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'name' => 'New Name',
        'email' => 'new_mail@librarian.com',
    ]);
});

/* ---------- delete user test ----------*/
it('can delete user', function () {
    loginAsUser();
    $user = User::factory()->create();
    $response = $this->deleteJson(route('user.delete', $user->id));
    $response->assertStatus(200);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
