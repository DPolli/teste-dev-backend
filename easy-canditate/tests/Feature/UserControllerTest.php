<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    public function test_can_list_users()
    {
        $user = User::factory()->create();
        User::factory(5)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'created_at']
                ]
            ]);
    }

    public function test_can_create_user()
    {
        $admin = User::factory()->create();
        
        $userData = [
            'name' => 'João Silva',
            'email' => 'joao@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->actingAs($admin)
            ->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'João Silva',
                'email' => 'joao@test.com'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'João Silva',
            'email' => 'joao@test.com'
        ]);
    }

    public function test_can_show_user()
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson("/api/users/{$targetUser->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $targetUser->id,
                'name' => $targetUser->name,
                'email' => $targetUser->email
            ]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        
        $updateData = [
            'name' => 'Nome Atualizado',
            'email' => 'novo@email.com'
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nome Atualizado',
            'email' => 'novo@email.com'
        ]);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/users/{$userToDelete->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id
        ]);
    }
}
