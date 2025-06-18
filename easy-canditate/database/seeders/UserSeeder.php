<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Diogo Polli',
            'email' => 'diogo_polli@gmail.com',
            'password' => Hash::make('tocontratado123'),
            'is_admin' => true,
            'type' => 'Candidato',
        ]);

        User::factory()->create([
            'name' => 'Recrutador Estech',
            'email' => 'recrutador_estech@gmail.com',
            'password' => Hash::make('mecontrata123'),
            'is_admin' => true,
            'type' => 'Recrutador',
        ]);

        User::factory(25)->create();
    }
}
