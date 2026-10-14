<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\AnimalNotFoundException;

class SQLAnimalService implements AnimalServiceInterface
{

    public function all(): array
    {
        $rows = DB::select(
            'SELECT animals.id,
                    animals.name,
                    species.name AS species,
                    animals.age
             FROM animals
             JOIN species ON species.id = animals.species_id'
        );

        $result = array_map(function ($row) {
            return (array) $row;
        }, $rows);

        return $result;
    }

    public function find(string $id): array
    {
        $row = DB::selectOne(
            'SELECT animals.id AS id,
                animals.name AS name,
                species.name AS species,
                species.id AS species_id,
                animals.age AS age
             FROM animals
             JOIN species ON species.id = animals.species_id
             WHERE animals.id = ?',
            [$id]
        );

        if (!$row) {
            AnimalNotFoundException::forId($id);
        }

        return (array) $row;
    }

    public function create(array $data): array
    {
        DB::insert(
            'INSERT INTO animals (name, species_id, age) VALUES (?, ?, ?)',
            [$data['name'], $data['species_id'], $data['age']]
        );

        $id = DB::getPdo()->lastInsertId();

        return $this->find($id);
    }

    public function update(string $id, array $data): array
    {
        // 1. Verificación previa (falla rápido con 404):
        $this->find($id);

        // 2. Sentencia SQL con los nuevos datos:
        DB::update(
            'UPDATE animals SET name = ?, species_id = ?, age = ? WHERE id = ?',
            [
                $data['name'],
                $data['species_id'],
                (int) $data['age'],
                $id
            ]
        );

        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        // Asegura existencia o lanza excepción:
        $this->find($id);

        $affected = DB::delete(
            'DELETE FROM animals WHERE id = ?',
            [$id]
        );

        return $affected > 0;
    }

    public function reset(): void
    {
        DB::statement('DELETE FROM animals');

        // Pro-Tip: Reiniciar el puntero autoincremental de SQLite
        DB::statement(
            "DELETE FROM sqlite_sequence WHERE name = 'animals'"
        );
    }
}
