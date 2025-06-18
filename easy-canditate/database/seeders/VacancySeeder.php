<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vacancy::factory()->create([
            'title' => 'Programador PHP Backend',
            'user_id' => 2,
            'contractor' => 'NEO Estech BR',
            'type' => 'PJ',
            'status' => 'Aberta',
            'description' => 'Vaga do Diogo :D'
        ]);

        Vacancy::factory(20)->create();
    }
}
