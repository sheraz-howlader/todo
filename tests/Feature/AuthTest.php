<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('login success::via rest api', function () {
    $this->withoutExceptionHandling();

    $password = 'Pa$$w0rd!';

    $user = User::factory()->make([
        'email' => 'admin@sherazdev.com.bd',
        'password' => Hash::make($password),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'You have successfully logged in!',
        ])
        ->assertJsonStructure([
            'success',
            'user' => ['id', 'name', 'email'],
            'token',
            'message',
        ]);
});

test('login fails::incorrect password', function () {
    $response = $this->postJson('/api/login', [
        'email' => "admin@sherazdev.com.bd",
        'password' => "wrongPassword",
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Access denied. Wrong password.'
        ]);
});

test('login fails::invalid email format', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'not-an-email',
        'password' => 'wrongPassword',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('login fails::missing email and password', function () {
    $response = $this->postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password'])
        ->assertJsonFragment([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);;
});

test('login fails::unregistered email', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongPassword',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'message' => 'No account associated with this email.'
        ]);
});



