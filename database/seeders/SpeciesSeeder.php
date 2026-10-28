<?php

namespace Database\Seeders;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    public function __construct(
        protected SpeciesServiceInterface $speciesService
    ) {}

    public function run(): void
    {
        $defaultSpecies = [
            ['name' => 'Perro'],
            ['name' => 'Gato'],
            ['name' => 'Loro'],
            ['name' => 'León'],
            ['name' => 'Pez payaso'],
        ];

        $this->speciesService->reset();

        foreach ($defaultSpecies as $data) {
            $this->speciesService->create($data);
        }
    }
}
