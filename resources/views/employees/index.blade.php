<x-app-layout>
   <x-slot name="header">
      <div class="d-flex justify-content-between align-items-center">
         <div>
            <h1 class="m-0 section-title">Cadastro de Colaboradores</h1>
            <p class="section-sub mb-0">Gestão transacional oficial dos colaboradores.</p>
         </div>
         @can('employees.create')
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Novo colaborador</a>
         @endcan
      </div>
   </x-slot>

   <x-ui.card>
      <form method="GET" action="{{ route('employees.index') }}" class="filter-bar mb-3">
         <input id="search" name="search" type="text" value="{{ request('search') }}" class="table-search"
            placeholder="🔍 Nome ou cargo">

         <select id="department_id" name="department_id" class="filter-select">
            <option value="">Todos os departamentos</option>
            @foreach ($departments as $department)
               <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->name }}</option>
            @endforeach
         </select>

         <select id="status" name="status" class="filter-select">
            <option value="">Todos status</option>
            @foreach ($statuses as $status)
               <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ ucfirst($status->value) }}</option>
            @endforeach
         </select>

         <button class="btn btn-primary" type="submit">Filtrar</button>
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
                  <td class="nome-col">{{ $employee->name }}</td>
                  <td>{{ $employee->department->name }}</td>
                  <td>{{ $employee->job_title }}</td>
                  <td>{{ $employee->hired_at->format('d/m/Y') }}</td>
                  <td>
                     <x-ui.badge :variant="$employee->status->value === 'active' ? 'success' : 'secondary'">
                        {{ ucfirst($employee->status->value) }}
                     </x-ui.badge>
                  </td>
                  <td class="text-end">
                     <div class="d-flex gap-1 justify-content-end">
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-light">Ver</a>
                        @can('employees.update')
                           <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-primary">Editar</a>
                        @endcan
                        @can('employees.delete')
                           <x-btn-delete :route="route('employees.destroy', $employee)" />
                        @endcan
                     </div>
                  </td>
               </tr>
            @empty
               <tr>
                  <td colspan="6" class="empty">Nenhum colaborador encontrado.</td>
               </tr>
            @endforelse
         </tbody>
      </x-ui.table>

      <div class="mt-3">
         {{ $employees->links() }}
      </div>
   </x-ui.card>
</x-app-layout>
