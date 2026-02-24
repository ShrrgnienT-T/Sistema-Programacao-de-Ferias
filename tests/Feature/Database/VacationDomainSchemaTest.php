<?php

namespace Tests\Feature\Database;

use App\Enums\EmployeeStatus;
use App\Enums\VacationRequestStatus;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\VacationBalanceAdjustment;
use App\Models\VacationRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class VacationDomainSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_tables_include_required_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('departments', [
            'name',
            'max_concurrent_vacations',
        ]));

        $this->assertTrue(Schema::hasColumns('employees', [
            'department_id',
            'name',
            'job_title',
            'hired_at',
            'vacation_days_per_year',
            'vacation_balance_days',
            'status',
        ]));

        $this->assertTrue(Schema::hasColumns('vacation_requests', [
            'employee_id',
            'starts_at',
            'ends_at',
            'days_requested',
            'status',
            'approved_by',
            'approved_at',
        ]));

        $this->assertTrue(Schema::hasColumns('vacation_balance_adjustments', [
            'employee_id',
            'adjusted_by',
            'previous_balance_days',
            'new_balance_days',
            'delta_days',
            'reason',
        ]));
    }

    public function test_models_persist_with_expected_relationships_and_enum_casts(): void
    {
        $department = Department::factory()->create();
        $employee = Employee::factory()->create([
            'department_id' => $department->id,
            'status' => EmployeeStatus::Active,
        ]);
        $manager = User::factory()->create();

        $request = VacationRequest::factory()->create([
            'employee_id' => $employee->id,
            'status' => VacationRequestStatus::Approved,
            'approved_by' => $manager->id,
            'approved_at' => now(),
        ]);

        $adjustment = VacationBalanceAdjustment::factory()->create([
            'employee_id' => $employee->id,
            'adjusted_by' => $manager->id,
            'previous_balance_days' => 20,
            'new_balance_days' => 18,
            'delta_days' => -2,
        ]);

        $this->assertTrue($employee->department->is($department));
        $this->assertTrue($request->employee->is($employee));
        $this->assertTrue($request->approver->is($manager));
        $this->assertTrue($adjustment->adjustedBy->is($manager));
        $this->assertSame(EmployeeStatus::Active, $employee->status);
        $this->assertSame(VacationRequestStatus::Approved, $request->status);
    }
}
