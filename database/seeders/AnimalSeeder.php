<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Contracts\AnimalServiceInterface;

class AnimalSeeder extends Seeder
{
    public function __construct(
        protected SpeciesSeeder $speciesSeeder,
        protected AnimalServiceInterface $animalService
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PASO 2: Asumiendo que las especies ya han sido creadas, podemos crear los animales con sus relaciones
        $animals = [
            ['name' => 'Milo', 'species_id' => 1, 'age' => 5],
            ['name' => 'Luna', 'species_id' => 2, 'age' => 2],
            ['name' => 'Paco', 'species_id' => 3, 'age' => 12],
            ['name' => 'Simba', 'species_id' => 4, 'age' => 4],
            ['name' => 'Nemo', 'species_id' => 5, 'age' => 1],
        ];

        $this->animalService->reset();

        foreach ($animals as $animal) {
            $this->animalService->create($animal);
        }
    }
}
