<?php

namespace App\Http\Controllers;

use App\Enums\EmployeeStatus;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensurePermission($request, 'employees.view');

        $employees = Employee::query()
            ->with('department')
            ->when($request->filled('department_id'), fn ($query) => $query->where('department_id', $request->integer('department_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->value()))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->value();
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('employees.index', [
            'employees' => $employees,
            'departments' => Department::query()->orderBy('name')->get(),
            'statuses' => EmployeeStatus::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->ensurePermission($request, 'employees.create');

        return view('employees.create', [
            'employee' => new Employee,
            'departments' => Department::query()->orderBy('name')->get(),
            'statuses' => EmployeeStatus::cases(),
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $employee = Employee::create($request->toPayload());

        return redirect()
            ->route('employees.show', $employee)
            ->with('status', 'Colaborador criado com sucesso.');
    }

    public function show(Request $request, Employee $employee): View
    {
        $this->ensurePermission($request, 'employees.view');

        $employee->load('department');

        return view('employees.show', [
            'employee' => $employee,
        ]);
    }

    public function edit(Request $request, Employee $employee): View
    {
        $this->ensurePermission($request, 'employees.update');

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => Department::query()->orderBy('name')->get(),
            'statuses' => EmployeeStatus::cases(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->toPayload());

        return redirect()
            ->route('employees.show', $employee)
            ->with('status', 'Colaborador atualizado com sucesso.');
    }

    private function ensurePermission(Request $request, string $permission): void
    {
        abort_unless($request->user()?->can($permission), 403);
    }
}
