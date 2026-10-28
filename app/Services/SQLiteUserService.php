<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;

class SQLiteUserService implements UserServiceInterface
{
    protected string $table = 'users';

    public function all(): array
    {
        return DB::table($this->table)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn ($item) => (array) $item)
            ->toArray();
    }

    public function find(string $id): ?array
    {
        $user = DB::table($this->table)->where('id', $id)->first();

        return $user ? (array) $user : null;
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
        $data['updated_at'] = now();
        $updated = DB::table($this->table)->where('id', $id)->update($data);

        return $updated ? $this->find($id) : null;
    }

    public function delete(string $id): bool
    {
        return DB::table($this->table)->where('id', $id)->delete() > 0;
    }

    public function reset(): void
    {
        DB::table($this->table)->delete();
        DB::statement(
            "DELETE FROM sqlite_sequence WHERE name='{$this->table}'"
        );
    }
}
