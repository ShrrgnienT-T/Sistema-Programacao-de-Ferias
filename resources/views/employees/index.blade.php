<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-0">Colaboradores</h1>
            @can('employees.create')
                <a href="{{ route('employees.create') }}" class="btn btn-primary">Novo colaborador</a>
            @endcan
        </div>
    </x-slot>

    <x-ui.card>
        <form method="GET" action="{{ route('employees.index') }}" class="row g-3 align-items-end mb-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <input id="search" name="search" type="text" value="{{ request('search') }}" class="form-control" placeholder="Nome ou cargo">
            </div>
            <div class="col-md-3">
                <label for="department_id" class="form-label">Departamento</label>
                <select id="department_id" name="department_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Todos</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ ucfirst($status->value) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid gap-2">
                <button class="btn btn-primary" type="submit">Filtrar</button>
            </div>
        </form>

        <x-ui.table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Departamento</th>
                    <th>Cargo</th>
                    <th>Admissão</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->department->name }}</td>
                        <td>{{ $employee->job_title }}</td>
                        <td>{{ $employee->hired_at->format('d/m/Y') }}</td>
                        <td>
                            <x-ui.badge :variant="$employee->status->value === 'active' ? 'success' : 'secondary'">
                                {{ ucfirst($employee->status->value) }}
                            </x-ui.badge>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            @can('employees.update')
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Nenhum colaborador encontrado.</td></tr>
                @endforelse
            </tbody>
        </x-ui.table>

        <div class="mt-3">
            {{ $employees->links() }}
        </div>
    </x-ui.card>
</x-app-layout>
