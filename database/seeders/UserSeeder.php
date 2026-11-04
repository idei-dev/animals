<?php

namespace Database\Seeders;

use App\Contracts\UserServiceInterface;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    public function run(): void
    {
        $defaultUsers = [
            ['name' => 'Admin',     'email' => 'admin@example.com',     'role' => 'admin'],
            ['name' => 'Empleado',  'email' => 'empleado@example.com',  'role' => 'employee'],
            ['name' => 'Cliente',   'email' => 'cliente@example.com',   'role' => 'customer'],
        ];

        // Agregar 10 usuarios de prueba adicionales con rol 'customer'
        for ($i = 1; $i <= 10; $i++) {
            $defaultUsers[] = [
                'name' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'role' => 'customer',
            ];
        }

        $this->userService->reset();

        foreach ($defaultUsers as $user) {
            $user['password'] = bcrypt('11111111');
            $this->userService->create($user);
        }
    }
}
