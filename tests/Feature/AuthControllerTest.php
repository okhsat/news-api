<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_registers_a_user()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user' => ['id', 'name', 'email'], 'token']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    #[Test]
    public function it_logs_in_a_user()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);
        $payload = [
            'email' => $user->email,
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user' => ['id','name','email'], 'token']);
    }

    #[Test]
    public function it_updates_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $payload = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];
        $response = $this->putJson('/api/profile', $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('name', 'Updated Name')
                 ->assertJsonPath('email', 'updated@example.com');

        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    #[Test]
    public function it_logs_out_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            
        ])->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out']);
    }
}