<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0">Controle de Férias — Morhena 2026</h1>
    </x-slot>

    <style>
        .morhena-shell { background:#05080f;color:#e8edf5;border-radius:14px;padding:16px;border:1px solid rgba(255,255,255,.08) }
        .morhena-tabs { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px }
        .morhena-tab-btn { border:1px solid rgba(255,255,255,.15); background:#0c1220; color:#94a3b8; border-radius:9px; padding:6px 12px; font-size:12px; font-weight:700 }
        .morhena-tab-btn.active { color:#fff; border-color:#6366f1; background:rgba(99,102,241,.2) }
        .morhena-grid { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:10px; margin-bottom:14px }
        .morhena-kpi { background:#0c1220;border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:12px }
        .morhena-kpi h4 { font-size:10px; text-transform:uppercase; color:#64748b; margin:0 0 6px }
        .morhena-kpi p { margin:0; font-size:28px; font-weight:800; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .morhena-kpi p.aprov { color:#22d3a0 } .morhena-kpi p.anali { color:#38bdf8 } .morhena-kpi p.pend { color:#fb923c }
        .morhena-pane { display:none } .morhena-pane.active { display:block }
        .morhena-filters { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px }
        .morhena-input { background:#111827; color:#e8edf5; border:1px solid rgba(255,255,255,.16); border-radius:8px; padding:6px 10px; font-size:12px }
        .morhena-table-wrap { overflow:auto; border:1px solid rgba(255,255,255,.08); border-radius:12px }
        .morhena-table { width:100%; min-width:900px; border-collapse:collapse }
        .morhena-table th,.morhena-table td { padding:8px 10px; border-bottom:1px solid rgba(255,255,255,.05); font-size:12px }
        .morhena-table th { position:sticky; top:0; background:#070d18; font-size:10px; text-transform:uppercase; color:#64748b }
        .s-aprov { color:#22d3a0; font-weight:700 } .s-anali { color:#38bdf8; font-weight:700 } .s-pend { color:#fb923c; font-weight:700 } .s-rep { color:#f87171; font-weight:700 }
        .calendar { overflow:auto; border:1px solid rgba(255,255,255,.08); border-radius:12px }
        .calendar table { width:100%; min-width:1100px; border-collapse:collapse }
        .calendar th,.calendar td { padding:6px; border-bottom:1px solid rgba(255,255,255,.05); text-align:center; font-size:11px }
        .calendar th:first-child,.calendar td:first-child { position:sticky; left:0; background:#0c1220; text-align:left; z-index:2 }
        .tag { border-radius:999px; padding:2px 8px; font-size:10px; border:1px solid }
        .tag.aprov { color:#22d3a0; border-color:rgba(34,211,160,.4) } .tag.anali { color:#38bdf8; border-color:rgba(56,189,248,.4) } .tag.pend { color:#fb923c; border-color:rgba(251,146,60,.4) }
        @media(max-width:1100px){ .morhena-grid{grid-template-columns:repeat(2,minmax(0,1fr));} }
    </style>

    <div class="morhena-shell">
        <div class="morhena-tabs">
            <button class="morhena-tab-btn active" data-pane="dashboard">📊 Dashboard</button>
            <button class="morhena-tab-btn" data-pane="programacao">📋 Programação</button>
            <button class="morhena-tab-btn" data-pane="calendario">📅 Calendário</button>
            <button class="morhena-tab-btn" data-pane="cadastro">👤 Cadastro</button>
        </div>

        <section class="morhena-pane active" id="pane-dashboard">
            <div class="morhena-grid">
                <div class="morhena-kpi"><h4>Total cadastrados</h4><p id="k-total">{{ $kpis['total'] }}</p></div>
                <div class="morhena-kpi"><h4>Aprovadas</h4><p class="aprov" id="k-aprov">{{ $kpis['approved'] }}</p></div>
                <div class="morhena-kpi"><h4>Em análise</h4><p class="anali" id="k-anali">{{ $kpis['in_review'] }}</p></div>
                <div class="morhena-kpi"><h4>Pendentes</h4><p class="pend" id="k-pend">{{ $kpis['pending'] }}</p></div>
                <div class="morhena-kpi"><h4>Sem programação</h4><p id="k-empty">{{ $kpis['without_schedule'] }}</p></div>
            </div>
            <canvas id="chart-status" height="90"></canvas>
        </section>

        <section class="morhena-pane" id="pane-programacao">
            <div class="morhena-filters">
                <input id="search" class="morhena-input" placeholder="Buscar colaborador...">
                <select id="status" class="morhena-input">
                    <option value="">Todos status</option>
                    <option>Aprovada</option>
                    <option>Em Análise</option>
                    <option>Pendente</option>
                    <option>Reprovada</option>
                </select>
            </div>
            <div class="morhena-table-wrap">
                <table class="morhena-table">
                    <thead>
                        <tr><th>#</th><th>Colaborador</th><th>Cargo</th><th>Departamento</th><th>Admissão</th><th>Início</th><th>Fim</th><th>Dias</th><th>Status</th></tr>
                    </thead>
                    <tbody id="programacao-body"></tbody>
                </table>
            </div>
        </section>

        <section class="morhena-pane" id="pane-calendario">
            <div class="calendar">
                <table>
                    <thead id="calendar-head"></thead>
                    <tbody id="calendar-body"></tbody>
                </table>
            </div>
        </section>

        <section class="morhena-pane" id="pane-cadastro">
            <p class="text-sm text-muted mb-2">Use o cadastro transacional para evitar inconsistências locais e manter trilha auditável.</p>
            <a href="{{ route('employees.index') }}" class="btn btn-primary btn-sm">Ir para Cadastro de Colaboradores</a>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        const rows = @json($rows);
        const months = ['JAN','FEV','MAR','ABR','MAI','JUN','JUL','AGO','SET','OUT','NOV','DEZ'];

        const statusClass = {
            'Aprovada': 's-aprov',
            'Em Análise': 's-anali',
            'Pendente': 's-pend',
            'Reprovada': 's-rep',
        };

        function fmt(date) {
            if (!date) return '—';
            const [y,m,d] = date.split('-');
            return `${d}/${m}/${y}`;
        }

        function renderProgramacao() {
            const body = document.getElementById('programacao-body');
            const search = document.getElementById('search').value.toLowerCase();
            const status = document.getElementById('status').value;

            const filtered = rows.filter((row) => {
                if (status && row.status !== status) return false;
                if (search && !row.nome.toLowerCase().includes(search)) return false;
                return true;
            });

            body.innerHTML = filtered.map((row) => `
                <tr>
                    <td>${row.id_f}</td>
                    <td>${row.nome}</td>
                    <td>${row.cargo || '—'}</td>
                    <td>${row.dept || '—'}</td>
                    <td>${fmt(row.admissao)}</td>
                    <td>${fmt(row.di)}</td>
                    <td>${fmt(row.df)}</td>
                    <td>${row.dias || '—'}</td>
                    <td><span class="${statusClass[row.status] || ''}">${row.status}</span></td>
                </tr>
            `).join('');

            if (!filtered.length) {
                body.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Nenhum registro encontrado.</td></tr>';
            }
        }

        function renderCalendar() {
            document.getElementById('calendar-head').innerHTML = `<tr><th>Colaborador</th>${months.map((m) => `<th>${m}</th>`).join('')}</tr>`;
            document.getElementById('calendar-body').innerHTML = rows.map((row) => {
                const startMonth = row.di ? Number(row.di.split('-')[1]) - 1 : null;

                return `<tr>
                    <td>${row.nome}</td>
                    ${months.map((_, idx) => {
                        if (startMonth !== idx) return '<td>—</td>';
                        const tagClass = row.status === 'Aprovada' ? 'aprov' : row.status === 'Em Análise' ? 'anali' : 'pend';
                        return `<td><span class="tag ${tagClass}">${row.status}</span></td>`;
                    }).join('')}
                </tr>`;
            }).join('');
        }

        function renderChart() {
            const dataset = {
                approved: rows.filter((r) => r.status === 'Aprovada').length,
                inReview: rows.filter((r) => r.status === 'Em Análise').length,
                pending: rows.filter((r) => r.status === 'Pendente').length,
                rejected: rows.filter((r) => r.status === 'Reprovada').length,
            };

            new Chart(document.getElementById('chart-status'), {
                type: 'bar',
                data: {
                    labels: ['Aprovada', 'Em Análise', 'Pendente', 'Reprovada'],
                    datasets: [{
                        data: [dataset.approved, dataset.inReview, dataset.pending, dataset.rejected],
                        backgroundColor: ['rgba(34,211,160,.6)', 'rgba(56,189,248,.6)', 'rgba(251,146,60,.6)', 'rgba(248,113,113,.6)'],
                        borderColor: ['#22d3a0', '#38bdf8', '#fb923c', '#f87171'],
                        borderWidth: 1,
                        borderRadius: 6,
                    }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,.05)' } },
                        x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                    },
                },
            });
        }

        document.querySelectorAll('.morhena-tab-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.morhena-tab-btn').forEach((el) => el.classList.remove('active'));
                document.querySelectorAll('.morhena-pane').forEach((el) => el.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(`pane-${btn.dataset.pane}`).classList.add('active');
            });
        });

        document.getElementById('search').addEventListener('input', renderProgramacao);
        document.getElementById('status').addEventListener('change', renderProgramacao);

        renderProgramacao();
        renderCalendar();
        renderChart();
    </script>
</x-app-layout>
