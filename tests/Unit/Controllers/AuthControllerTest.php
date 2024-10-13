<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(RefreshDatabase::class, WithFaker::class);

// Test class for AuthController
it('can log in using valid credentials', function () {
    // Create a user for testing
    $user = User::factory()->create(['password' => Hash::make('password')]);

    // Mock login request payload
    $payload = ['email' => $user->email, 'password' => 'password'];

    // Make a POST request to the login endpoint
    $response = $this->post('/api/login', $payload);

    // Assert response status and structure
    $response->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure([
                'id',
                'email',
                'name',
                'token',
                'role',
                'response' => ['status'],
            ]);

    // Assert that a plain text token was generated for the user
    $this->assertNotNull($user->tokens()->first());
});

it('cannot log in using invalid credentials', function () {
    // Create a user for testing
    User::factory()->create();

    // Mock login request payload
    $payload = ['email' => 'invalid@example.com', 'password' => 'invalid'];

    // Make a POST request to the login endpoint
    $response = $this->post('/api/login', $payload);

    // Assert response status and structure
    $response->assertStatus(Response::HTTP_OK)
             ->assertJson(['response' => ['status' => false]]);

    // Assert that no token was generated for the user
    $this->assertNull(Auth::user());
});

it('can edit a user with valid input', function () {
    // Create a user for testing
    $user = User::factory()->create();

    // Mock update request payload
    $payload = [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ];

    // Make a POST request to the update endpoint
    $response = $this->post('/api/edit-user', $payload);

    // Assert response status and structure
    $response->assertStatus(Response::HTTP_OK)
             ->assertJson(['status' => true]);
});

it('cannot edit a user with invalid input', function () {
    // Create a user for testing
    $user = User::factory()->create();

    // Create another user with a conflicting email
    User::factory()->create(['email' => 'conflict@example.com']);

    // Mock update request payload with conflicting email
    $payload = [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'conflict@example.com',
    ];

    // Make a POST request to the update endpoint
    $response = $this->post('/api/edit-user', $payload);

    // Assert response status and structure
    $response->assertStatus(Response::HTTP_OK)
             ->assertJson(['status' => false]);
});

it('can logout successfully', function () {
    // Create a user for testing
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;

    // Authenticate user and set token
    Auth::login($user);
    $this->withHeader('Authorization', "Bearer $token");

    // Make a POST request to the logout endpoint
    $response = $this->post('/api/logout');

    // Assert response status and structure
    $response->assertStatus(Response::HTTP_OK)
             ->assertJson(['status' => true]);

    // Assert that the token was deleted
    $this->assertEmpty($user->tokens);
});
