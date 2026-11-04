<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Contracts\UserServiceInterface;
use App\Contracts\AnimalServiceInterface;
use App\Contracts\AnimalOwnerServiceInterface;

class AnimalOwnerSeeder extends Seeder
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected AnimalServiceInterface $animalService,
        protected AnimalOwnerServiceInterface $animalOwnerService
    ) {
    }

    public function run(): void
    {
        $this->animalOwnerService->reset();

        $dueños = $this->userService->customers();
        $mascotas = $this->animalService->all();

        // Asignar un dueño aleatorio a cada mascota
        foreach ($mascotas as $mascota) {
            // Asignar un dueño aleatorio a cada mascota
            $mascotaId = $mascota['id'];
            $dueñoId = $dueños[rand(0, \count($dueños) - 1)]['id'];

            $this->animalOwnerService->assign($mascotaId, $dueñoId);
            $this->animalOwnerService->setPrimary($mascotaId, $dueñoId);
        }
    }
}
