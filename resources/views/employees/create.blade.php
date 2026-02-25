<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0">Novo colaborador</h1>
    </x-slot>

    <x-ui.card>
        <form method="POST" action="{{ route('employees.store') }}">
            @csrf
            @include('employees._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('employees.index') }}" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
