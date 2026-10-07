<?php

namespace App\Services;

use App\Contracts\SpeciesServiceInterface;
use App\Exceptions\SpeciesNotFoundException;

class SpeciesMockService implements SpeciesServiceInterface
{
    protected string $sessionKey = 'species';

    public function __construct()
    {
        if (!session()->has($this->sessionKey)) {
            $this->reset();
        }
    }

    public function all(): array
    {
        return session()->get($this->sessionKey, []);
    }

    public function find(string $id): ?array
    {
        $items = $this->all();

        if (!isset($items[$id])) {
            throw SpeciesNotFoundException::forId($id);
        }

        return $items[$id];
    }

    public function create(array $data): array
    {
        $items = $this->all();
        $newId = uniqid();
        $items[$newId] = $data;
        session([$this->sessionKey => $items]);
        return ['id' => $newId] + $data;
    }

    public function update(string $id, array $data): ?array
    {
        $items = session($this->sessionKey, []);
        if (!isset($items[$id])) {
            throw new \Exception("El animal con ID \"$id\" no fue encontrado.");
        }
        $items[$id] = $data;
        session([$this->sessionKey => $items]);
        return ['id' => $id] + $data;
    }

    public function delete(string $id): bool
    {
        $items = session($this->sessionKey, []);
        if (!isset($items[$id])) {
            throw new \Exception("El animal con ID \"$id\" no fue encontrado.");
        }
        unset($items[$id]);
        session([$this->sessionKey => $items]);
        return true;
    }

    public function reset(): void
    {
        session()->forget($this->sessionKey);
    }

}
