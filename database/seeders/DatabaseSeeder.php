<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\VacationBalanceAdjustment;
use App\Models\VacationRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $departments = Department::factory()->count(4)->create();

        $employees = Employee::factory()
            ->count(20)
            ->recycle($departments)
            ->create();

        VacationRequest::factory()
            ->count(45)
            ->recycle([$employees, $admin])
            ->create();

        VacationBalanceAdjustment::factory()
            ->count(10)
            ->recycle([$employees, $admin])
            ->create();
    }
}
