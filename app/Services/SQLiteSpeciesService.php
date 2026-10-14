<?php

namespace App\Services;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteSpeciesService implements SpeciesServiceInterface
{
    protected string $table = 'species';

    public function all(): array
    {

        /**
         * Pseudocódigo:
         * 1. Cargar en $items todo lo que devuelve "SELECT * FROM species ORDER BY id ASC"
         * 2. Convertir cada elemento de $items a un array asociativo
         * 2.a. For each $item in $items, convert $item to an associative array
         * 3. Devolver $items como un array de arrays asociativos
         */

        return DB::table($this->table)      // SELECT * FROM species
            ->orderBy('id', 'asc')          // ORDER BY id ASC
            ->get()                         // Ejecutar la consulta y obtener los resultados
            ->map(fn ($item) => (array) $item)
            ->toArray();
    }

    public function find(string $id): ?array
    {
        /**
         * Pseudocódigo:
         * 1. Cargar en $item lo que devuelve "SELECT * FROM species WHERE id = $id"
         * 2. Si $item es null, devolver null
         * 3. Si $item no es null, convertirlo a un array asociativo
         * 4. Devolver $item como un array asociativo
         */
        $item = DB::table($this->table)
            ->where('id', $id)
            ->first();

        /**
         * if ($item === null) {
         *     return null;
         * } else {
         *    return (array) $item;
         * }
         */

        return $item ? (array) $item : null;
    }

    public function create(array $data): array
    {
        /**
         * INSERT INTO species (name) VALUES ($data['name'])
         * SELECT * FROM species WHERE id = $id
         * 
         * Pseudocódigo:
         * 1. Insertar en la tabla $this->table los datos de $data
         * 2. Obtener el ID del registro insertado
         * 3. Buscar y devolver el registro con ese ID
         */
        $id = DB::table($this->table)->insertGetId([
            'name' => $data['name']
        ]);

        return $this->find((string) $id);
    }

    public function update(string $id, array $data): ?array
    {
        $affected = DB::table($this->table)
            ->where('id', $id)
            ->update([
                'name' => $data['name']
            ]);

        if ($affected === 0 && ! $this->find($id)) {
            return null;
        }

        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        $deleted = DB::table($this->table)
            ->where('id', $id)
            ->delete();

        return $deleted > 0;
    }

    public function reset(): void
    {
        DB::table($this->table)->delete();
        DB::statement(
            "DELETE FROM sqlite_sequence WHERE name='{$this->table}'"
        );
    }
}
