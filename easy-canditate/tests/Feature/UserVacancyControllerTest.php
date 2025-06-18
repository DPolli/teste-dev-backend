<?php

namespace Tests\Feature;

use App\Models\{User, Vacancy, UserVacancy};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserVacancyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    public function test_can_list_user_vacancies()
    {
        $user = User::factory()->create();
        UserVacancy::factory(3)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/user-vacancies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'user_id', 'vacancy_id', 'status',
                        'user' => ['id', 'name', 'email'],
                        'vacancy' => ['id', 'title', 'description']
                    ]
                ]
            ]);
    }

    public function test_can_search_user_vacancies()
    {
        $user = User::factory()->create(['name' => 'João Silva']);
        $vacancy = Vacancy::factory()->create(['title' => 'Desenvolvedor PHP']);
        UserVacancy::factory()->create([
            'user_id' => $user->id,
            'vacancy_id' => $vacancy->id
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/user-vacancies?search=João');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'João Silva']);
    }

    public function test_can_sort_user_vacancies()
    {
        $user = User::factory()->create();
        UserVacancy::factory(3)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/user-vacancies?sort=created_at&direction=desc');

        $response->assertStatus(200);
    }

    public function test_can_create_user_vacancy()
    {
        $user = User::factory()->create();
        $vacancy = Vacancy::factory()->create();

        $data = [
            'user_id' => $user->id,
            'vacancy_id' => $vacancy->id,
            'status' => 'applied'
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/user-vacancies', $data);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('user_vacancies', $data);
    }
}
