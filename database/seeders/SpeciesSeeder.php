<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('species')->count() > 0) {
            return;
        }

        DB::table('species')->insert([
            ['name' => 'Perro'],
            ['name' => 'Gato'],
            ['name' => 'Loro'],
        ]);
    }
}
