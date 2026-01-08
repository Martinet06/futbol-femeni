<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);

        User::create([
            'name' => 'Marti',
            'email' => 'marti@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $this->call([
            EstadisSeeder::class,
            EquipsSeeder::class,
            JugadoresSeeder::class,
            PartitsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
