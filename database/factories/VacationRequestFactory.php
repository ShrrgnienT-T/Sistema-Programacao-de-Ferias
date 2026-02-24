<?php

namespace Database\Factories;

use App\Enums\VacationRequestStatus;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VacationRequest>
 */
class VacationRequestFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-3 months', '+6 months');
        $days = fake()->numberBetween(5, 20);
        $end = (clone $start)->modify(sprintf('+%d days', $days - 1));
        $status = fake()->randomElement(VacationRequestStatus::cases());

        return [
            'employee_id' => Employee::factory(),
            'starts_at' => $start->format('Y-m-d'),
            'ends_at' => $end->format('Y-m-d'),
            'days_requested' => $days,
            'status' => $status,
            'coverage_notes' => fake()->optional()->sentence(),
            'notes' => fake()->optional()->sentence(),
            'approved_by' => in_array($status, [VacationRequestStatus::Approved, VacationRequestStatus::Rejected], true)
                ? User::factory()
                : null,
            'approved_at' => in_array($status, [VacationRequestStatus::Approved, VacationRequestStatus::Rejected], true)
                ? fake()->dateTimeBetween('-2 months', 'now')
                : null,
        ];
    }
}
