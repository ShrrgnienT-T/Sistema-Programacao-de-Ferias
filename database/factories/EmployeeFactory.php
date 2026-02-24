<?php

namespace Database\Factories;

use App\Enums\EmployeeStatus;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name' => fake()->name(),
            'job_title' => fake()->jobTitle(),
            'hired_at' => fake()->dateTimeBetween('-10 years', '-2 months')->format('Y-m-d'),
            'vacation_days_per_year' => 30,
            'vacation_balance_days' => fake()->randomFloat(2, 0, 30),
            'status' => fake()->randomElement([EmployeeStatus::Active, EmployeeStatus::Inactive]),
        ];
    }
}
