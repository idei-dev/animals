<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // PASO 1: Cambiar el orden de los seeders para que SpeciesSeeder se ejecute antes que AnimalSeeder
        $this->call([
            SpeciesSeeder::class,
            AnimalSeeder::class,
        ]);
    }
}
