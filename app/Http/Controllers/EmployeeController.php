<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentShift;
use App\Enums\EmployeeJobTitle;
use App\Enums\EmployeeStatus;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Traits\FilterTrait;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    use FilterTrait;

    protected array $exactMatchFields = ['department_id', 'status'];
    protected array $searchableColumns = ['name', 'job_title'];

    public function index(Request $request): View
    {
        $this->ensurePermission($request, 'employees.view');

        $query = Employee::query()->with('department');
        $this->filter($query, $request);

        $employees = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('employees.index', [
            'employees' => $employees,
            'departments' => $this->availableDepartments(),
            'statuses' => EmployeeStatus::cases(),
            'jobTitles' => EmployeeJobTitle::values(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->ensurePermission($request, 'employees.create');

        return view('employees.create', [
            'employee' => new Employee,
            'departments' => $this->availableDepartments(),
            'statuses' => EmployeeStatus::cases(),
            'jobTitles' => EmployeeJobTitle::values(),
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $employee = Employee::create($request->toPayload());

        toast('Colaborador criado com sucesso!', 'success');

        return redirect()->route('employees.show', $employee);
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
            'departments' => $this->availableDepartments(),
            'statuses' => EmployeeStatus::cases(),
            'jobTitles' => EmployeeJobTitle::values(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->toPayload());

        toast('Colaborador atualizado com sucesso!', 'success');

        return redirect()->route('employees.show', $employee);
    }

    public function destroy(Request $request, Employee $employee): RedirectResponse
    {
        $this->ensurePermission($request, 'employees.delete');

        $employee->delete();

        toast('Colaborador excluído com sucesso!', 'success');

        return redirect()->route('employees.index');
    }

    private function ensurePermission(Request $request, string $permission): void
    {
        abort_unless($request->user()?->can($permission), 403);
    }

    private function availableDepartments()
    {
        foreach (DepartmentShift::values() as $departmentName) {
            Department::query()->firstOrCreate(['name' => $departmentName]);
        }

        return Department::query()->orderBy('name')->get();
    }
}
