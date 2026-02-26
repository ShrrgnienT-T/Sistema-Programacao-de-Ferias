<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Higienização',
            'Coleta',
            'Rouparia',
            'Administrativo',
            'Supervisão',
            'RH',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(
                ['name' => $name],
                ['name' => $name, 'max_concurrent_vacations' => 2]
            );
        }
    }
}
