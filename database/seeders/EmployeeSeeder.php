<?php

namespace Database\Seeders;

use App\Enums\EmployeeJobTitle;
use App\Enums\EmployeeStatus;
use App\Enums\VacationRequestStatus;
use App\Models\Department;
use App\Models\Employee;
use App\Models\VacationRequest;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            $this->call(DepartmentSeeder::class);
            $departments = Department::all();
        }

        $employees = [
            // Employees with approved vacations
            ['name' => 'Maria Silva Santos', 'job_title' => EmployeeJobTitle::Asg, 'hired_at' => '2022-03-15', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-03-01', 'ends_at' => '2026-03-30', 'days' => 30]],
            ['name' => 'João Pedro Almeida', 'job_title' => EmployeeJobTitle::Collector, 'hired_at' => '2021-06-10', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-06-15', 'ends_at' => '2026-07-14', 'days' => 30]],
            ['name' => 'Ana Paula Oliveira', 'job_title' => EmployeeJobTitle::Housekeeping, 'hired_at' => '2020-11-20', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-11-01', 'ends_at' => '2026-11-30', 'days' => 30]],
            
            // Employees in review
            ['name' => 'Carlos Eduardo Lima', 'job_title' => EmployeeJobTitle::Asg, 'hired_at' => '2023-02-25', 'vacation' => ['status' => VacationRequestStatus::InReview, 'starts_at' => '2026-04-15', 'ends_at' => '2026-05-14', 'days' => 30]],
            ['name' => 'Fernanda Costa Reis', 'job_title' => EmployeeJobTitle::Supervisor, 'hired_at' => '2019-08-12', 'vacation' => ['status' => VacationRequestStatus::InReview, 'starts_at' => '2026-08-01', 'ends_at' => '2026-08-20', 'days' => 20]],
            
            // Employees pending (without vacation request or pending status)
            ['name' => 'Roberto Souza Martins', 'job_title' => EmployeeJobTitle::Collector, 'hired_at' => '2024-01-10', 'vacation' => null],
            ['name' => 'Patrícia Lima Ferreira', 'job_title' => EmployeeJobTitle::Asg, 'hired_at' => '2023-09-05', 'vacation' => null],
            
            // Employees with cycle alerts (hired 11+ months ago without vacation)
            ['name' => 'Lucas Mendes Barbosa', 'job_title' => EmployeeJobTitle::Housekeeping, 'hired_at' => '2025-04-10', 'vacation' => null], // ~11 months
            ['name' => 'Juliana Rocha Dias', 'job_title' => EmployeeJobTitle::Asg, 'hired_at' => '2025-03-01', 'vacation' => null], // ~12 months - urgent
            
            // More employees for diversity
            ['name' => 'Marcos Antônio Silva', 'job_title' => EmployeeJobTitle::HrAnalyst, 'hired_at' => '2021-04-20', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-05-01', 'ends_at' => '2026-05-30', 'days' => 30]],
            ['name' => 'Cláudia Pereira Santos', 'job_title' => EmployeeJobTitle::Coordinator, 'hired_at' => '2018-12-01', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-12-15', 'ends_at' => '2027-01-14', 'days' => 30]],
            ['name' => 'Thiago Oliveira Costa', 'job_title' => EmployeeJobTitle::Analyst, 'hired_at' => '2022-07-15', 'vacation' => ['status' => VacationRequestStatus::InReview, 'starts_at' => '2026-07-20', 'ends_at' => '2026-08-18', 'days' => 30]],
            ['name' => 'Amanda Ribeiro Lima', 'job_title' => EmployeeJobTitle::Asg, 'hired_at' => '2024-05-20', 'vacation' => null],
            ['name' => 'Felipe Gomes Nascimento', 'job_title' => EmployeeJobTitle::Collector, 'hired_at' => '2023-10-08', 'vacation' => ['status' => VacationRequestStatus::Rejected, 'starts_at' => '2026-10-01', 'ends_at' => '2026-10-15', 'days' => 15]],
            ['name' => 'Renata Carvalho Souza', 'job_title' => EmployeeJobTitle::Housekeeping, 'hired_at' => '2022-01-30', 'vacation' => ['status' => VacationRequestStatus::Approved, 'starts_at' => '2026-02-01', 'ends_at' => '2026-02-28', 'days' => 28, 'coverage' => 'Cobertura: Maria Silva']],
        ];

        foreach ($employees as $index => $empData) {
            $department = $departments[$index % $departments->count()];
            
            $employee = Employee::firstOrCreate(
                ['name' => $empData['name']],
                [
                    'department_id' => $department->id,
                    'name' => $empData['name'],
                    'job_title' => $empData['job_title'],
                    'hired_at' => $empData['hired_at'],
                    'vacation_days_per_year' => 30,
                    'vacation_balance_days' => 30,
                    'status' => EmployeeStatus::Active,
                ]
            );

            if ($empData['vacation']) {
                VacationRequest::firstOrCreate(
                    ['employee_id' => $employee->id, 'starts_at' => $empData['vacation']['starts_at']],
                    [
                        'employee_id' => $employee->id,
                        'starts_at' => $empData['vacation']['starts_at'],
                        'ends_at' => $empData['vacation']['ends_at'],
                        'days_requested' => $empData['vacation']['days'],
                        'status' => $empData['vacation']['status'],
                        'coverage_notes' => $empData['vacation']['coverage'] ?? null,
                    ]
                );
            }
        }
    }
}
