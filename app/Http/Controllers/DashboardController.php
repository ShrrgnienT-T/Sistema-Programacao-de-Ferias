<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentShift;
use App\Enums\VacationPlanningMonth;
use App\Enums\VacationPlanningStatus;
use App\Enums\VacationRequestStatus;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()?->can('dashboard.view'), 403);

        $employees = Employee::query()
            ->with([
                'department:id,name',
                'latestVacationRequest',
            ])
            ->orderBy('name')
            ->get();

        $departments = Department::orderBy('name')->pluck('name', 'id');

        $rows = $employees->map(function (Employee $employee): array {
            $request = $employee->latestVacationRequest;

            return [
                'id' => $employee->id,
                'id_f' => 'F'.str_pad((string) $employee->id, 3, '0', STR_PAD_LEFT),
                'nome' => $employee->name,
                're' => '',
                'cargo' => $employee->job_title?->value ?? $employee->job_title,
                'dept' => $employee->department?->name ?? '',
                'dept_id' => $employee->department_id,
                'admissao' => $employee->hired_at?->format('Y-m-d') ?? '',
                'mes' => $request?->starts_at?->translatedFormat('F') ? ucfirst((string) $request->starts_at->translatedFormat('F')) : '',
                'di' => $request?->starts_at?->format('Y-m-d') ?? '',
                'df' => $request?->ends_at?->format('Y-m-d') ?? '',
                'dias' => $request?->days_requested ?? 0,
                'status' => $this->statusLabel($request?->status),
                'cobertura' => $request?->coverage_notes ?? '',
            ];
        })->values();

        return view('dashboard', [
            'rows' => $rows,
            'kpis' => $this->kpis($rows),
            'departments' => $departments,
            'planningMonths' => VacationPlanningMonth::values(),
            'planningStatuses' => VacationPlanningStatus::values(),
            'departmentShifts' => DepartmentShift::values(),
        ]);
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $rows
     * @return array<string, int>
     */
    private function kpis(Collection $rows): array
    {
        return [
            'total' => $rows->count(),
            'approved' => $rows->where('status', 'Aprovada')->count(),
            'in_review' => $rows->where('status', 'Em Análise')->count(),
            'pending' => $rows->where('status', 'Pendente')->count(),
            'rejected' => $rows->where('status', 'Reprovada')->count(),
            'without_schedule' => $rows->where('di', '')->count(),
        ];
    }

    private function statusLabel(?VacationRequestStatus $status): string
    {
        return match ($status) {
            VacationRequestStatus::Approved => 'Aprovada',
            VacationRequestStatus::InReview => 'Em Análise',
            VacationRequestStatus::Rejected => 'Reprovada',
            default => 'Pendente',
        };
    }
}
