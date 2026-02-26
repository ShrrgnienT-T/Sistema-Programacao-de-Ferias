<x-app-layout>
   <x-slot name="header">
      <div class="d-flex justify-content-between align-items-center">
         <h1 class="m-0 section-title">{{ $employee->name }}</h1>
         <div class="d-flex gap-2">
            @can('employees.update')
               <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">Editar</a>
            @endcan
            @can('employees.delete')
               <x-btn-delete :route="route('employees.destroy', $employee)">Excluir</x-btn-delete>
            @endcan
         </div>
      </div>
   </x-slot>

   <x-ui.card>
      <dl class="row mb-0 details-list">
         <dt class="col-sm-3">Departamento</dt>
         <dd class="col-sm-9">{{ $employee->department->name }}</dd>

         <dt class="col-sm-3">Cargo</dt>
         <dd class="col-sm-9">{{ $employee->job_title }}</dd>

         <dt class="col-sm-3">Admissão</dt>
         <dd class="col-sm-9">{{ $employee->hired_at->format('d/m/Y') }}</dd>

         <dt class="col-sm-3">Dias de férias/ano</dt>
         <dd class="col-sm-9">{{ $employee->vacation_days_per_year }}</dd>

         <dt class="col-sm-3">Saldo atual</dt>
         <dd class="col-sm-9">{{ number_format($employee->vacation_balance_days, 2, ',', '.') }}</dd>

         <dt class="col-sm-3">Status</dt>
         <dd class="col-sm-9">
            <x-ui.badge :variant="$employee->status->value === 'active' ? 'success' : 'secondary'">
               {{ ucfirst($employee->status->value) }}
            </x-ui.badge>
         </dd>
      </dl>
   </x-ui.card>
</x-app-layout>
