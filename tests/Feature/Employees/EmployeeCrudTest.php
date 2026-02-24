<?php

namespace Tests\Feature\Employees;

use App\Enums\EmployeeStatus;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_index_requires_employee_view_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('employees.index'))
            ->assertForbidden();
    }

    public function test_user_with_permission_can_list_and_filter_employees(): void
    {
        $departmentA = Department::factory()->create(['name' => 'Tecnologia']);
        $departmentB = Department::factory()->create(['name' => 'Financeiro']);

        $match = Employee::factory()->create([
            'department_id' => $departmentA->id,
            'name' => 'Ana Souza',
            'status' => EmployeeStatus::Active,
        ]);

        $ignored = Employee::factory()->create([
            'department_id' => $departmentB->id,
            'name' => 'Bruno Lima',
            'status' => EmployeeStatus::Inactive,
        ]);

        $user = $this->createUserWithPermission('employees.view');

        $this->actingAs($user)
            ->get(route('employees.index', ['department_id' => $departmentA->id, 'status' => EmployeeStatus::Active->value]))
            ->assertOk()
            ->assertSee($match->name)
            ->assertDontSee($ignored->name);
    }

    public function test_user_with_create_permission_can_store_employee(): void
    {
        $department = Department::factory()->create();
        $user = $this->createUserWithPermission('employees.create');

        $this->actingAs($user)
            ->post(route('employees.store'), [
                'department_id' => $department->id,
                'name' => 'Maria Santos',
                'job_title' => 'Analista de RH',
                'hired_at' => '2024-01-15',
                'vacation_days_per_year' => 30,
                'status' => EmployeeStatus::Active->value,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('employees', [
            'name' => 'Maria Santos',
            'job_title' => 'Analista de RH',
            'vacation_balance_days' => '30.00',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = $this->createUserWithPermission('employees.create');

        $this->actingAs($user)
            ->post(route('employees.store'), [])
            ->assertSessionHasErrors(['department_id', 'name', 'job_title', 'hired_at', 'vacation_days_per_year', 'status']);
    }

    public function test_user_with_update_permission_can_update_employee(): void
    {
        $department = Department::factory()->create();
        $employee = Employee::factory()->create([
            'department_id' => $department->id,
            'name' => 'Nome Antigo',
        ]);

        $user = $this->createUserWithPermission('employees.update');

        $this->actingAs($user)
            ->put(route('employees.update', $employee), [
                'department_id' => $department->id,
                'name' => 'Nome Novo',
                'job_title' => 'Coordenador',
                'hired_at' => '2023-05-01',
                'vacation_days_per_year' => 25,
                'status' => EmployeeStatus::Inactive->value,
            ])
            ->assertRedirect(route('employees.show', $employee));

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Nome Novo',
            'status' => EmployeeStatus::Inactive->value,
        ]);
    }

    private function createUserWithPermission(string $permission): User
    {
        Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }
}
