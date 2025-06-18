<?php

namespace Database\Seeders;

use App\Models\UserVacancy;
use Illuminate\Database\Seeder;

class UserVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserVacancy::factory()->create([
            'user_id' => 1,
            'vacancy_id' => 1
        ]);

        UserVacancy::factory(30)->create();
    }
}
