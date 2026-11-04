<?php

namespace App\Services;

use App\Contracts\AnimalOwnerServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteAnimalOwnerService implements AnimalOwnerServiceInterface
{
    protected string $table = 'animal_user';

    public function all(string $animalId): array
    {
        return DB::table($this->table)
            ->join('users', 'users.id', '=', "{$this->table}.user_id")
            ->where("{$this->table}.animal_id", $animalId)
            ->select(
                'users.*',
                "{$this->table}.is_primary"
            )
            ->orderByDesc("{$this->table}.is_primary")
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public function assign(string $animalId, string $userId): bool
    {
        // La restricción UNIQUE de la migración garantiza que no haya
        // asociaciones duplicadas.
        try {
            return DB::table($this->table)->insert([
                'animal_id' => $animalId,
                'user_id' => $userId,
                'is_primary' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            // No ocultar errores de base de datos. Una asociación duplicada
            // puede tratarse como resultado false si se identifica el error
            // específico del motor; otros errores deben propagarse.
            throw $exception;
        }
    }

    public function remove(string $animalId, string $userId): bool
    {
        return DB::table($this->table)
            ->where('animal_id', $animalId)
            ->where('user_id', $userId)
            ->delete() > 0;
    }

    public function setPrimary(string $animalId, string $userId): bool
    {
        return DB::transaction(function () use ($animalId, $userId) {
            $exists = DB::table($this->table)
                ->where('animal_id', $animalId)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                return false;
            }

            DB::table($this->table)
                ->where('animal_id', $animalId)
                ->update([
                    'is_primary' => false,
                    'updated_at' => now(),
                ]);

            return DB::table($this->table)
                ->where('animal_id', $animalId)
                ->where('user_id', $userId)
                ->update([
                    'is_primary' => true,
                    'updated_at' => now(),
                ]) > 0;
        });
    }

    public function animals(string $userId): array
    {
        return DB::table($this->table)
            ->join('animals', 'animals.id', '=', "{$this->table}.animal_id")
            ->where("{$this->table}.user_id", $userId)
            ->select(
                'animals.*',
                "{$this->table}.is_primary"
            )
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public function reset(): void
    {
        DB::table($this->table)->delete();
        DB::statement(
            "DELETE FROM sqlite_sequence WHERE name='{$this->table}'"
        );
    }
}
