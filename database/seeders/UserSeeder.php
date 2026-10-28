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
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'John Doe', 'email' => 'john.doe@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com'],
        ];

        $this->userService->reset();

        foreach ($defaultUsers as $user) {
            $user['password'] = bcrypt('11111111'); // Set a default password for all users
            if (! isset($user['role'])) {
                $user['role'] = 'customer'; // Default role if not specified
            }
            $this->userService->create($user);
        }
    }
}
