<?php

/**
 * Paso 2: El Servicio (Extrayendo la lógica de negocio/datos)
 * Ahora creamos una clase concreta que implemente esta interfaz. Aquí es donde moveremos
 * toda la "basura" de la sesión que ensuciaba el controlador. Esto cumple con el SRP.
 */
namespace App\Services;

use App\Contracts\AnimalServiceInterface;

class SessionAnimalService implements AnimalServiceInterface
{
    private const SESSION_KEY = 'animals';

    public function __construct()
    {
        $this->seedIfNeeded();
    }

    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function find(string $id): ?array
    {
        return session(self::SESSION_KEY . '.' . $id);
    }

    public function create(array $data): void
    {
        $id = uniqid();
        session()->put(self::SESSION_KEY . '.' . $id, $data);
    }

    public function update(string $id, array $data): bool
    {
        if (!$this->find($id)) return false;

        session()->put(self::SESSION_KEY . '.' . $id, $data);
        return true;
    }

    public function delete(string $id): bool
    {
        if (!$this->find($id)) return false;

        session()->forget(self::SESSION_KEY . '.' . $id);
        return true;
    }

    public function reset(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    private function seedIfNeeded(): void
    {
        if (!session()->has(self::SESSION_KEY)) {
            $key1 = uniqid();
            $key2 = uniqid();
            $key3 = uniqid();
            session([
                self::SESSION_KEY => [
                    $key1 => ['name' => 'Leo',  'species' => 'León',       'age' => 5 ],
                    $key2 => ['name' => 'Dora', 'species' => 'Elefante',   'age' => 10],
                    $key3 => ['name' => 'Nemo', 'species' => 'Pez Payaso', 'age' => 2 ],
                ],
            ]);
        }
    }
}
