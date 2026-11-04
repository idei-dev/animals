<?php

namespace App\Services;

use App\Contracts\AnimalEventServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteAnimalEventService implements AnimalEventServiceInterface
{
    protected string $table = 'animal_events';

    public function all(string $animalId): array
    {
        return DB::table($this->table)
            ->where('animal_id', $animalId)
            ->orderBy('event_date', 'desc')
            ->get()
            ->map(fn ($item) => (array) $item)
            ->toArray();
    }

    public function find(string $id): ?array
    {
        $event = DB::table($this->table)
            ->where('id', $id)
            ->first();

        return $event ? (array) $event : null;
    }

    public function create(array $data): array
    {
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $id = DB::table($this->table)->insertGetId($data);

        return $this->find((string) $id);
    }

    public function update(string $id, array $data): ?array
    {
        if (!$this->find($id)) {
            return null;
        }

        $data['updated_at'] = now();

        DB::table($this->table)
            ->where('id', $id)
            ->update($data);

        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->delete() > 0;
    }

    public function reset(): void
    {
        DB::table($this->table)->truncate();
        DB::statement('DELETE FROM sqlite_sequence WHERE name = ?', [$this->table]);
    }
}