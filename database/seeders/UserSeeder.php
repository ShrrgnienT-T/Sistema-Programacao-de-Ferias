<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'password' => 'password',
            ],
        );

        $hr = User::firstOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR User',
                'password' => 'password',
            ],
        );

        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => 'password',
            ],
        );

        $admin->syncRoles(['admin']);
        $hr->syncRoles(['hr']);
        $manager->syncRoles(['manager']);
    }
}
