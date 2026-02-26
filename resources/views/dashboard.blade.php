<x-app-layout>
    <x-slot name="header">
        <div class="section-title">Painel de Controle</div>
        <div class="section-sub">Visão consolidada · dados oficiais do backend</div>
    </x-slot>

    <div id="morhena-dashboard-root" data-component="morhena-dashboard">
        @include('dashboard.partials.tabs')
        @include('dashboard.partials.tab-dashboard')
        @include('dashboard.partials.tab-programacao')
        @include('dashboard.partials.tab-calendario')
        @include('dashboard.partials.tab-cadastro')

        @php($dashboardData = [
            'rows' => $rows,
            'kpis' => $kpis,
            'planningMonths' => $planningMonths,
            'planningStatuses' => $planningStatuses,
            'departmentShifts' => $departmentShifts,
        ])
        <script id="morhena-dashboard-data" type="application/json">@json($dashboardData)</script>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
</x-app-layout>
