<?php

namespace App\Services;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Support\Str;

/**
 * Paso 2: Creamos un mock para probar.
 */
class SpeciesMockService implements SpeciesServiceInterface
{
    protected string $sessionKey = 'species_mock_data';

    /**
     * Datos iniciales para pruebas.
     */
    protected array $defaultSpecies = [
        [
            'id' => '1',
            'name' => 'Perro'
        ],
        [
            'id' => '2',
            'name' => 'Gato'
        ],
        [
            'id' => '3',
            'name' => 'Loro'
        ],
    ];

    public function __construct()
    {
        // Si no existen datos en sesión, inicializamos con los valores por defecto
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

        return collect($items)->firstWhere('id', $id);
    }

    public function create(array $data): array
    {
        $items = $this->all();

        // Generamos un ID simple o UUID si no viene en los datos
        $newItem = array_merge($data, [
            'id' => (string) ($data['id'] ?? (string) Str::uuid()),
        ]);

        $items[] = $newItem;
        session()->put($this->sessionKey, $items);

        return $newItem;
    }

    public function update(string $id, array $data): ?array
    {
        $items = $this->all();
        $updated = null;

        foreach ($items as $index => $item) {
            if ($item['id'] === $id) {
                // Conservamos el id original y combinamos los campos
                $items[$index] = array_merge($item, $data, ['id' => $id]);
                $updated = $items[$index];
                break;
            }
        }

        if ($updated) {
            session()->put($this->sessionKey, $items);
        }

        return $updated;
    }

    public function delete(string $id): bool
    {
        $items = $this->all();
        $initialCount = count($items);

        $filtered = array_values(array_filter($items, fn($item) => $item['id'] !== $id));

        if (count($filtered) !== $initialCount) {
            session()->put($this->sessionKey, $filtered);
            return true;
        }

        return false;
    }

    public function reset(): void
    {
        session()->put($this->sessionKey, $this->defaultSpecies);
    }
}
