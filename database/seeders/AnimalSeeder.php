<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            ['name' => 'Milo', 'species' => 'Perro', 'age' => 5],
            ['name' => 'Luna', 'species' => 'Gato', 'age' => 2],
            ['name' => 'Paco', 'species' => 'Loro', 'age' => 12],
        ];

        foreach ($animals as $animal) {

            DB::insert(
                'INSERT INTO animals (name, species, age) VALUES (?, ?, ?)',
                [
                    $animal['name'],
                    $animal['species'],
                    $animal['age']
                ]
            );
        }

        DB::insert(
            'INSERT INTO animals (name, species, age) VALUES ("Rocky", "Perro", 3)'
        );

        DB::table('animals')->insert([
            ['name' => 'Simba', 'species' => 'León', 'age' => 4],
            ['name' => 'Nemo', 'species' => 'Pez payaso', 'age' => 1],
        ]);
    }
}
