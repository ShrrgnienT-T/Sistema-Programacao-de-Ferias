import { initMorhenaTabs } from './tabs';

function formatDate(date) {
    if (!date) return '—';
    const [year, month, day] = date.split('-');
    return `${day}/${month}/${year}`;
}

function statusBadgeClass(status) {
    if (status === 'Aprovada') return 'badge aprov';
    if (status === 'Em Análise') return 'badge anali';
    if (status === 'Reprovada') return 'badge danger';
    return 'badge pend';
}

export function initMorhenaDashboard() {
    const root = document.getElementById('morhena-dashboard-root');
    const payload = document.getElementById('morhena-dashboard-data');

    if (!root || !payload) return;

    initMorhenaTabs(root);

    const { rows, kpis } = JSON.parse(payload.textContent);
    const searchInput = document.getElementById('programacao-search');
    const statusSelect = document.getElementById('programacao-status');

    document.getElementById('kpi-total').textContent = kpis.total;
    document.getElementById('kpi-aprov').textContent = kpis.approved;
    document.getElementById('kpi-anali').textContent = kpis.in_review;
    document.getElementById('kpi-pend').textContent = kpis.pending;
    document.getElementById('kpi-empty').textContent = kpis.without_schedule;

    const renderProgramacao = () => {
        const search = (searchInput?.value || '').toLowerCase();
        const status = statusSelect?.value || '';
        const tbody = document.getElementById('programacao-tbody');

        const filtered = rows.filter((row) => {
            if (status && row.status !== status) return false;
            if (search && !row.nome.toLowerCase().includes(search)) return false;
            return true;
        });

        tbody.innerHTML = filtered.map((row) => `
            <tr>
                <td>${row.id_f}</td>
                <td class="nome-col">${row.nome}</td>
                <td>${row.cargo || '—'}</td>
                <td>${row.dept || '—'}</td>
                <td>${formatDate(row.admissao)}</td>
                <td>${formatDate(row.di)}</td>
                <td>${formatDate(row.df)}</td>
                <td>${row.dias || '—'}</td>
                <td><span class="${statusBadgeClass(row.status)}">${row.status}</span></td>
            </tr>
        `).join('');

        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="9" class="empty">Nenhum registro encontrado.</td></tr>';
        }
    };

    const renderCalendar = () => {
        const months = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
        document.getElementById('cal-thead').innerHTML = `<tr><th class="col-name">Colaborador</th>${months.map((month) => `<th>${month}</th>`).join('')}</tr>`;

        document.getElementById('cal-tbody').innerHTML = rows.map((row) => {
            const startMonth = row.di ? Number(row.di.split('-')[1]) - 1 : null;
            return `<tr>
                <td class="col-name">${row.nome}</td>
                ${months.map((_, idx) => idx === startMonth ? `<td><span class="cal-cell ${statusBadgeClass(row.status).split(' ')[1]}">${row.status}</span></td>` : '<td></td>').join('')}
            </tr>`;
        }).join('');
    };

    const renderChart = () => {
        if (typeof Chart === 'undefined') return;

        new Chart(document.getElementById('chart-status'), {
            type: 'bar',
            data: {
                labels: ['Aprovada', 'Em Análise', 'Pendente', 'Reprovada'],
                datasets: [{
                    data: [kpis.approved, kpis.in_review, kpis.pending, rows.filter((row) => row.status === 'Reprovada').length],
                    backgroundColor: ['rgba(34,211,160,.6)', 'rgba(56,189,248,.6)', 'rgba(251,146,60,.6)', 'rgba(248,113,113,.6)'],
                    borderRadius: 6,
                }],
            },
            options: {
                plugins: { legend: { display: false } },
            },
        });
    };

    searchInput?.addEventListener('input', renderProgramacao);
    statusSelect?.addEventListener('change', renderProgramacao);

    document.getElementById('date-chip').textContent = new Date().toLocaleDateString('pt-BR', { day: '2-digit', month: 'short', year: 'numeric' });

    renderProgramacao();
    renderCalendar();
    renderChart();
}
