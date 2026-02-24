<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VacationBalanceAdjustment>
 */
class VacationBalanceAdjustmentFactory extends Factory
{
    public function definition(): array
    {
        $previous = fake()->randomFloat(2, 0, 30);
        $delta = fake()->randomFloat(2, -10, 10);
        $new = max(0, $previous + $delta);

        return [
            'employee_id' => Employee::factory(),
            'adjusted_by' => User::factory(),
            'previous_balance_days' => $previous,
            'new_balance_days' => $new,
            'delta_days' => round($new - $previous, 2),
            'reason' => fake()->sentence(),
        ];
    }
}
