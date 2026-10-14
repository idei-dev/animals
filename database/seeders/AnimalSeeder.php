<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Contracts\AnimalServiceInterface;

class AnimalSeeder extends Seeder
{

   public function __construct(
        protected AnimalServiceInterface $animalService
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            ['name' => 'Milo', 'species' => 'Perro', 'age' => 5],
            ['name' => 'Luna', 'species' => 'Gato', 'age' => 2],
            ['name' => 'Paco', 'species' => 'Loro', 'age' => 12],
            ['name' => 'Simba', 'species' => 'León', 'age' => 4],
            ['name' => 'Nemo', 'species' => 'Pez payaso', 'age' => 1],
        ];

        $this->animalService->reset();

        foreach ($animals as $animal) {
            $this->animalService->create($animal);
        }
    }
}
