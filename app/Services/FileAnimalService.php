<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileAnimalService implements AnimalServiceInterface
{
    /**
     * Métodos Auxiliares (Principio DRY)
     */
    private function getAnimals(): array
    {
        // Verifica si el archivo existe usando la Facade Storage
        if (!Storage::disk('local')->exists('animals.json')) {
            return []; // Retorna array vacío si no existe
        }
        
        $json = Storage::disk('local')->get('animals.json');
        
        // Transforma el string del archivo a un array asociativo con json_decode
        return json_decode($json, true) ?? [];
    }

    private function saveAnimals(array $animals): void
    {
        // Guarda los datos con formato legible y ordenado usando JSON_PRETTY_PRINT[cite: 5]
        $jsonContent = json_encode($animals, JSON_PRETTY_PRINT);
        
        // Escribe el archivo en disco[cite: 5]
        Storage::disk('local')->put('animals.json', $jsonContent);
    }

    /**
     * Implementación del Contrato
     */
    public function all(): array
    {
        return $this->getAnimals();
    }

    public function find(int|string $id)
    {
        $animals = $this->getAnimals();
        
        foreach ($animals as $animal) {
            if ($animal['id'] == $id) {
                return $animal;
            }
        }
        
        // Arroja la excepción exacta requerida si no encuentra el ID[cite: 5]
        throw new Exception("El animal con ID {$id} no fue encontrado.");
    }

    public function create(array $data): array
    {
        $animals = $this->getAnimals();
        
        // Calcula el próximo ID autoincremental[cite: 5]
        $nextId = empty($animals) ? 1 : max(array_column($animals, 'id')) + 1;
        $data['id'] = $nextId;
        
        // Agrega el nuevo registro y guarda el archivo en disco[cite: 5]
        $animals[] = $data;
        $this->saveAnimals($animals);
        
        // Retorna el recurso recién creado[cite: 5]
        return $data;
    }

    public function delete(int|string $id): bool
    {
        $animals = $this->getAnimals();
        $initialCount = count($animals);
        
        // Filtra el array eliminando el animal que coincida con el ID
        $animals = array_filter($animals, function($animal) use ($id) {
            return $animal['id'] != $id;
        });
        
        if (count($animals) === $initialCount) {
            // Arroja excepción si el ID no existía para ser eliminado[cite: 5]
            throw new Exception("El animal con ID {$id} no fue encontrado.");
        }
        
        // Reindexa el array con array_values y persiste el cambio en disco[cite: 5]
        $this->saveAnimals(array_values($animals));
        
        return true; // Retorna true como exige la firma[cite: 5]
    }

    public function reset(): void
    {
        // Inicializa el archivo con los datos semilla (seeders) por defecto de la cátedra[cite: 5]
        $this->saveAnimals([
            [
                "id" => 1,
                "name" => "Milo",
                "species" => "Perro",
                "age" => 4
            ],
            [
                "id" => 2,
                "name" => "Luna",
                "species" => "Gato",
                "age" => 2
            ]
        ]);
    }
}