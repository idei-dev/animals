<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\AnimalNotFoundException;

class SQLAnimalService implements AnimalServiceInterface
{

    public function all(): array
    {
        $rows = DB::select('SELECT id, name, species, age FROM animals');

        $result = array_map(function ($row) {
            return (array) $row;
        }, $rows);

        return $result;
    }

    public function find(string $id): array
    {
        $row = DB::selectOne('SELECT id, name, species, age FROM animals WHERE id = ?', [$id]);

        if (!$row) {
            AnimalNotFoundException::forId($id);
        }

        return (array) $row;
    }

    public function create(array $data): array
    {
        DB::insert(
            'INSERT INTO animals (name, species, age) VALUES (?, ?, ?)',
            [$data['name'], $data['species'], $data['age']]
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
            'UPDATE animals SET name = ?, species = ?, age = ? WHERE id = ?',
            [
                $data['name'],
                $data['species'],
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
