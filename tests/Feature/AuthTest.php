<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Ensures database is reset for each test

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'status',
                'data' => ['token'],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Logged in successfully.',
                'status' => 200,
            ]);

        $this->assertNotEmpty($response->json('data.token'));
    }

    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message',
                'status',
                'errors',
                'data',
            ])
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials.',
                'status' => 401,
            ]);
    }

    public function test_login_requires_email_and_password(): void
    {
        // Test missing email
        $responseMissingEmail = $this->postJson('/api/login', [
            'password' => 'password123',
        ]);

        $responseMissingEmail->assertStatus(422) // Unprocessable Entity for validation errors
            ->assertJsonValidationErrors(['email']);

        // Test missing password
        $responseMissingPassword = $this->postJson('/api/login', [
            'email' => 'test@example.com',
        ]);

        $responseMissingPassword->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_login_requires_a_valid_email_format(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'not-an-email',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
