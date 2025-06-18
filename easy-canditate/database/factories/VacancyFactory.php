<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['type' => 'Recrutador']),
            'title' => $this->faker->randomElement([
                'Desenvolvedor', 'Analista', 'Engenheiro', 'Especialista'
            ]) . ' ' . $this->faker->randomElement([
                'PHP', 'Laravel', 'Vue.js', 'React', 'Fullstack', 'Backend', 'Frontend', 'Dados', 'DevOps'
            ]),
            'contractor' => $this->faker->company(),
            'type' => $this->faker->randomElement(['CLT', 'PJ', 'Freelancer']),
            'status' => $this->faker->randomElement(['Aberta', 'Pausada', 'Fechada']),
            'description' => $this->faker->paragraph(3)
        ];
    }
}
