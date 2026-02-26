<?php

namespace Tests\Feature\Dashboard;

use App\Enums\VacationRequestStatus;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\VacationRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_dashboard_requires_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    }

    public function test_dashboard_renders_records_from_domain_data(): void
    {
        $department = Department::factory()->create(['name' => 'Gestão']);
        $employee = Employee::factory()->create([
            'department_id' => $department->id,
            'name' => 'Ana Maria',
            'job_title' => 'Analista',
            'hired_at' => '2024-01-10',
        ]);

        VacationRequest::factory()->create([
            'employee_id' => $employee->id,
            'starts_at' => '2026-05-05',
            'ends_at' => '2026-05-24',
            'days_requested' => 20,
            'status' => VacationRequestStatus::Approved,
        ]);

        $user = $this->userWithPermission('dashboard.view');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Controle de Férias — Morhena 2026')
            ->assertSee('Ana Maria')
            ->assertSee('Aprovada')
            ->assertSee('Janeiro')
            ->assertSee('Diurno Par')
            ->assertSee('Sem Departamento');
    }

    private function userWithPermission(string $permission): User
    {
        Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }
}
