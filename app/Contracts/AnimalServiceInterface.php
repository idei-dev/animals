<?php

namespace App\Contracts;

interface AnimalServiceInterface
{
    public function all(): array;
    public function find(int|string $id);
    public function create(array $data): array;
    public function delete(int|string $id): bool;
    public function reset(): void;
}