<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Contracts\SpeciesServiceInterface;

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
        ];

        $this->speciesService->reset();

        foreach ($defaultSpecies as $data) {
            $this->speciesService->create($data);
        }
        
        // $items = $this->speciesService->all();
        // $strItems = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // echo $strItems;
    }
}
