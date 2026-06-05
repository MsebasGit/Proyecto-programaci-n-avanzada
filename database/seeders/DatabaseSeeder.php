<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Sebastian Medrano',
            'email' => 'sebastian11medrano@gmail.com',
            'password' => '1HEz8kIqyPvJYI',
        ]);

        $this->call([
            MateriaSeeder::class,
            HabilidadSeeder::class,
        ]);
    }
}
