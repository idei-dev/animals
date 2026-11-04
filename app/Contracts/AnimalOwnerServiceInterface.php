<?php

namespace App\Contracts;

interface AnimalOwnerServiceInterface
{
    /**
     * Obtiene los usuarios asociados a una mascota.
     */
    public function all(string $animalId): array;

    /**
     * Asocia un usuario con una mascota.
     */
    public function assign(string $animalId, string $userId): bool;

    /**
     * Elimina la asociación entre un usuario y una mascota.
     */
    public function remove(string $animalId, string $userId): bool;

    /**
     * Establece cuál de los usuarios asociados es el responsable principal.
     */
    public function setPrimary(string $animalId, string $userId): bool;

    /**
     * Obtiene las mascotas asociadas a un usuario.
     */
    public function animals(string $userId): array;

    /**
     * Elimina todas las asociaciones entre usuarios y mascotas.
     */
    public function reset(): void;
}