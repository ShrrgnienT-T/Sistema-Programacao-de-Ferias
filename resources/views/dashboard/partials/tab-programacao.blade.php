<div class="tab" id="tab-programacao">
    <div class="filter-bar">
        <input class="table-search" id="programacao-search" placeholder="🔍 Buscar colaborador...">

        <select class="filter-select" id="programacao-month">
            <option value="">📆 Todos os Meses</option>
            @foreach ($planningMonths as $month)
                <option value="{{ $month }}">{{ $month }}</option>
            @endforeach
        </select>

        <select class="filter-select" id="programacao-department">
            <option value="">🏢 Todos os Departamentos</option>
            @foreach ($departmentShifts as $shift)
                <option value="{{ $shift }}">{{ $shift }}</option>
            @endforeach
        </select>

        <select class="filter-select" id="programacao-status">
            <option value="">Todos status</option>
            @foreach ($planningStatuses as $status)
                <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>Colaborador</th><th>Cargo</th><th>Departamento</th><th>Admissão</th><th>Mês Prev.</th><th>Início</th><th>Fim</th><th>Dias</th><th>Status</th>
                    </tr>
                </thead>
                <tbody id="programacao-tbody"></tbody>
            </table>
        </div>
    </div>
</div>
