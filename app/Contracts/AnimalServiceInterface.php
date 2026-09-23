<?php

/**
 * Paso 1: El Contrato (Definiendo la Interfaz)
 * Para cumplir con el DIP (depender de abstracciones, no de implementaciones), crearemos una interfaz.
 * Esto le dirá al controlador qué se puede hacer, sin importarle cómo se hace.
 */
namespace App\Contracts;

interface AnimalServiceInterface
{
    public function all(): array;
    public function find(string $id): ?array;
    public function create(array $data): void;
    public function update(string $id, array $data): bool;
    public function delete(string $id): bool;
    public function reset(): void;
}
