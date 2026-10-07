<?php

namespace App\Services;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteSpeciesService implements SpeciesServiceInterface
{
    protected string $table = 'species';

    public function all(): array
    {
        return DB::table($this->table)
            ->orderBy('id', 'asc')
            ->get()
            ->map(fn ($item) => (array) $item)
            ->toArray();
    }

    public function find(string $id): ?array
    {
        $item = DB::table($this->table)
            ->where('id', $id)
            ->first();

        return $item ? (array) $item : null;
    }

    public function create(array $data): array
    {
        $now = now();

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
        // En SQLite / DB pura truncamos o vaciamos y repoblamos
        DB::table($this->table)->delete();

        $now = now();
        DB::table($this->table)->insert([
            ['id' => 1, 'name' => 'Canino'],
            ['id' => 2, 'name' => 'Felino'],
            ['id' => 3, 'name' => 'Loro'],
        ]);
    }
}
