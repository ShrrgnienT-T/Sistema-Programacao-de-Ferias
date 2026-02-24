<x-app-layout>
    <x-slot name="header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-4">
        <x-ui.card>
            <p class="text-sm text-gray-500">Total de colaboradores</p>
            <p class="text-2xl font-bold">0</p>
        </x-ui.card>

        <x-ui.card>
            <p class="text-sm text-gray-500">Em férias hoje</p>
            <p class="text-2xl font-bold">0</p>
        </x-ui.card>

        <x-ui.card>
            <p class="text-sm text-gray-500">Próximos 30 dias</p>
            <p class="text-2xl font-bold">0</p>
        </x-ui.card>

        <x-ui.card>
            <p class="text-sm text-gray-500">Status do sistema</p>
            <x-ui.badge variant="success">MVP em implantação</x-ui.badge>
        </x-ui.card>
    </div>

    <x-ui.card title="Próximas entregas">
        <x-ui.table>
            <thead>
                <tr>
                    <th>Epic</th>
                    <th>Foco</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>EPIC 2</td>
                    <td>Modelagem de banco</td>
                    <td><x-ui.badge variant="warning">Próximo passo</x-ui.badge></td>
                </tr>
                <tr>
                    <td>EPIC 3</td>
                    <td>Cadastro de colaboradores</td>
                    <td><x-ui.badge>Planejado</x-ui.badge></td>
                </tr>
            </tbody>
        </x-ui.table>
    </x-ui.card>
</x-app-layout>
