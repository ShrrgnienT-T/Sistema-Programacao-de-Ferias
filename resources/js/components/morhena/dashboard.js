import { initMorhenaTabs } from './tabs';

// Utility functions
function formatDate(date) {
    if (!date) return '—';
    const [year, month, day] = date.split('-');
    return `${day}/${month}/${year}`;
}

function formatDateRange(di, df) {
    if (!di && !df) return '—';
    return `${formatDate(di)} → ${formatDate(df)}`;
}

function statusBadgeClass(status) {
    if (status === 'Aprovada') return 'badge aprov';
    if (status === 'Em Análise') return 'badge anali';
    if (status === 'Reprovada') return 'badge danger';
    return 'badge pend';
}

function statusCalClass(status) {
    if (status === 'Aprovada') return 'cal-cell aprov';
    if (status === 'Em Análise') return 'cal-cell anali';
    if (status === 'Reprovada') return 'cal-cell danger';
    return 'cal-cell pend';
}

function resolveMonth(row) {
    if (row.mes) return row.mes;
    if (!row.di) return '';
    const monthIndex = Number(row.di.split('-')[1]) - 1;
    const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    return months[monthIndex] || '';
}

function normalizeDepartment(dept) {
    return dept && dept.trim().length > 0 ? dept : 'Sem Departamento';
}

function getAvatarBg(name) {
    const colors = ['#22d3a0', '#38bdf8', '#fb923c', '#f87171', '#a78bfa', '#fbbf24', '#34d399', '#60a5fa'];
    let hash = 0;
    for (let i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
    return colors[Math.abs(hash) % colors.length];
}

function getInitials(name) {
    const parts = name.trim().split(' ').filter(Boolean);
    if (parts.length >= 2) return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    return parts[0]?.substring(0, 2).toUpperCase() || '??';
}

function calculateCycleInfo(admissao) {
    if (!admissao) return null;

    const hiredDate = new Date(admissao);
    const today = new Date();
    const currentYear = today.getFullYear();

    // Calculate next anniversary
    let nextAniv = new Date(currentYear, hiredDate.getMonth(), hiredDate.getDate());
    if (nextAniv <= today) {
        nextAniv = new Date(currentYear + 1, hiredDate.getMonth(), hiredDate.getDate());
    }

    const diffTime = nextAniv - today;
    const daysRemaining = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const yearsWorked = Math.floor((today - hiredDate) / (1000 * 60 * 60 * 24 * 365.25));

    return {
        yearsWorked,
        nextAniv,
        daysRemaining,
        cycleNumber: yearsWorked + 1,
        isUrgent: daysRemaining <= 60,
        isWarning: daysRemaining <= 120 && daysRemaining > 60
    };
}

function renderCycleBar(admissao, hasVacation) {
    const info = calculateCycleInfo(admissao);
    if (!info) return '<span class="no-adm">Sem data</span>';

    const pct = Math.max(0, Math.min(100, ((365 - info.daysRemaining) / 365) * 100));
    let fillClass = 'ok-fill';
    let txtClass = 'ok-txt';

    if (!hasVacation) {
        if (info.isUrgent) {
            fillClass = 'urgent-fill';
            txtClass = 'urgent-txt';
        } else if (info.isWarning) {
            fillClass = 'warn-fill';
            txtClass = 'warn-txt';
        }
    }

    return `
        <span class="ciclo-bar-wrap">
            <span class="ciclo-bar-fill ${fillClass}" style="width:${pct}%"></span>
        </span>
        <span class="${txtClass}">${info.daysRemaining}d</span>
        ${info.isWarning && !hasVacation ? '<span class="alert-dot">!</span>' : ''}
        ${info.isUrgent && !hasVacation ? '<span class="alert-dot urgent">!!</span>' : ''}
    `;
}

export function initMorhenaDashboard() {
    const root = document.getElementById('morhena-dashboard-root');
    const payload = document.getElementById('morhena-dashboard-data');

    if (!root || !payload) return;

    initMorhenaTabs(root);

    const data = JSON.parse(payload.textContent);
    const { rows, kpis, departments = [] } = data;

    let currentFilter = '';
    let currentMonth = '';
    let currentDepartment = '';
    let currentSearch = '';
    let currentPage = 1;
    const perPage = 15;

    // Elements
    const searchInput = document.getElementById('programacao-search');
    const monthSelect = document.getElementById('programacao-month');
    const departmentSelect = document.getElementById('programacao-department');
    const chips = root.querySelectorAll('.chip[data-status]');
    const clearBtn = document.getElementById('btn-clear-filters');
    const modal = document.getElementById('modal-employee');
    const employeeForm = document.getElementById('form-employee');
    const cancelBtn = document.getElementById('btn-cancel-modal');
    const addBtns = root.querySelectorAll('#btn-add-employee, #btn-add-employee-cadastro');

    // Populate departments
    const uniqueDepts = [...new Set(rows.map(r => normalizeDepartment(r.dept)))].sort();
    if (departmentSelect) {
        uniqueDepts.forEach(dept => {
            const opt = document.createElement('option');
            opt.value = dept;
            opt.textContent = dept;
            departmentSelect.appendChild(opt);
        });
    }

    // Calculate alerts
    const alertEmployees = rows.filter(row => {
        const info = calculateCycleInfo(row.admissao);
        return info && (info.isWarning || info.isUrgent) && !row.di;
    });

    // Update KPIs
    function updateKPIs() {
        document.getElementById('kpi-total').textContent = kpis.total;
        document.getElementById('kpi-aprov').textContent = kpis.approved;
        document.getElementById('kpi-anali').textContent = kpis.in_review;
        document.getElementById('kpi-pend').textContent = kpis.pending;
        document.getElementById('kpi-empty').textContent = kpis.without_schedule;
        document.getElementById('kpi-alerts').textContent = alertEmployees.length;

        const alertCard = document.getElementById('kpi-alerts-card');
        if (alertCard && alertEmployees.length > 0) {
            alertCard.classList.add('has-alerts');
        }

        // Segmentation
        const total = kpis.total || 1;
        document.getElementById('seg-aprov').textContent = kpis.approved;
        document.getElementById('seg-anali').textContent = kpis.in_review;
        document.getElementById('seg-pend').textContent = kpis.pending;

        const pctAprov = Math.round((kpis.approved / total) * 100);
        const pctAnali = Math.round((kpis.in_review / total) * 100);
        const pctPend = Math.round((kpis.pending / total) * 100);

        document.getElementById('seg-bar-aprov').style.width = pctAprov + '%';
        document.getElementById('seg-bar-anali').style.width = pctAnali + '%';
        document.getElementById('seg-bar-pend').style.width = pctPend + '%';

        document.getElementById('seg-pct-aprov').textContent = pctAprov + '%';
        document.getElementById('seg-pct-anali').textContent = pctAnali + '%';
        document.getElementById('seg-pct-pend').textContent = pctPend + '%';

        // Badges
        const badgeProg = document.getElementById('badge-programacao');
        if (badgeProg) badgeProg.textContent = kpis.total;

        const badgeAlerts = document.getElementById('badge-alerts');
        if (badgeAlerts) {
            badgeAlerts.textContent = alertEmployees.length;
            badgeAlerts.classList.toggle('hidden', alertEmployees.length === 0);
        }
    }

    // Filter rows
    function getFilteredRows() {
        return rows.filter(row => {
            if (currentFilter && row.status !== currentFilter) return false;
            if (currentMonth && resolveMonth(row) !== currentMonth) return false;
            if (currentDepartment && normalizeDepartment(row.dept) !== currentDepartment) return false;
            if (currentSearch && !row.nome.toLowerCase().includes(currentSearch.toLowerCase())) return false;
            return true;
        });
    }

    // Render Programacao table
    function renderProgramacao() {
        const tbody = document.getElementById('programacao-tbody');
        const filtered = getFilteredRows();
        const totalPages = Math.ceil(filtered.length / perPage);
        const start = (currentPage - 1) * perPage;
        const paginated = filtered.slice(start, start + perPage);

        tbody.innerHTML = paginated.map(row => {
            const avatarBg = getAvatarBg(row.nome);
            const initials = getInitials(row.nome);
            const hasVacation = !!row.di;

            return `
                <tr data-id="${row.id}">
                    <td>${row.id_f}</td>
                    <td class="nome-col">
                        <span class="avatar" style="background:${avatarBg}">${initials}</span>
                        ${row.nome}
                    </td>
                    <td>${row.cargo || '—'}</td>
                    <td>${normalizeDepartment(row.dept)}</td>
                    <td>${renderCycleBar(row.admissao, hasVacation)}</td>
                    <td>${resolveMonth(row) || '—'}</td>
                    <td>${formatDateRange(row.di, row.df)}</td>
                    <td>${row.dias || '—'}</td>
                    <td><span class="${statusBadgeClass(row.status)}">${row.status}</span></td>
                    <td class="td-actions">
                        <button class="btn-edit" data-id="${row.id}">✏️</button>
                        <button class="btn-del" data-id="${row.id}">🗑️</button>
                    </td>
                </tr>
            `;
        }).join('');

        if (!paginated.length) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center text-muted" style="padding:32px">Nenhum registro encontrado.</td></tr>';
        }

        // Update filter count
        const countEl = document.getElementById('filter-count');
        if (countEl) countEl.textContent = `${filtered.length} registro${filtered.length !== 1 ? 's' : ''}`;

        // Pagination
        renderPagination(filtered.length, totalPages);
    }

    function renderPagination(total, totalPages) {
        const info = document.getElementById('pagination-info');
        const btns = document.getElementById('pagination-btns');

        if (info) {
            const start = (currentPage - 1) * perPage + 1;
            const end = Math.min(currentPage * perPage, total);
            info.textContent = `Mostrando ${total > 0 ? start : 0}-${end} de ${total}`;
        }

        if (btns) {
            let html = '';
            for (let i = 1; i <= totalPages; i++) {
                html += `<button class="pg-btn ${i === currentPage ? 'on' : ''}" data-page="${i}">${i}</button>`;
            }
            btns.innerHTML = html;

            btns.querySelectorAll('.pg-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPage = parseInt(btn.dataset.page);
                    renderProgramacao();
                });
            });
        }
    }

    // Render Calendar
    function renderCalendar() {
        const months = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];

        document.getElementById('cal-thead').innerHTML = `
            <tr>
                <th class="col-name">Colaborador</th>
                <th class="col-setor">Setor</th>
                ${months.map(m => `<th>${m}</th>`).join('')}
            </tr>
        `;

        document.getElementById('cal-tbody').innerHTML = rows.map(row => {
            const avatarBg = getAvatarBg(row.nome);
            const initials = getInitials(row.nome);
            const startMonth = row.di ? Number(row.di.split('-')[1]) - 1 : null;
            const endMonth = row.df ? Number(row.df.split('-')[1]) - 1 : startMonth;

            return `
                <tr>
                    <td class="col-name">
                        <div class="cal-name-inner">
                            <span class="cal-avatar" style="background:${avatarBg}">${initials}</span>
                            <span class="cal-nome">${row.nome}</span>
                        </div>
                    </td>
                    <td class="col-setor">${normalizeDepartment(row.dept)}</td>
                    ${months.map((_, idx) => {
                if (startMonth !== null && idx >= startMonth && idx <= (endMonth ?? startMonth)) {
                    const dias = idx === startMonth ? (row.dias || '') : '';
                    return `<td><span class="${statusCalClass(row.status)}">${dias ? dias + 'd' : '●'}</span></td>`;
                }
                return '<td></td>';
            }).join('')}
                </tr>
            `;
        }).join('');
    }

    // Render Alerts
    function renderAlerts() {
        const banner = document.getElementById('alert-banner');
        const cards = document.getElementById('alert-cards');
        const noAlerts = document.getElementById('no-alerts');
        const alertCount = document.getElementById('alert-count');

        if (alertCount) alertCount.textContent = alertEmployees.length;

        if (alertEmployees.length === 0) {
            if (banner) banner.classList.add('hidden');
            if (cards) cards.classList.add('hidden');
            if (noAlerts) noAlerts.classList.remove('hidden');
            return;
        }

        if (banner) banner.classList.remove('hidden');
        if (cards) cards.classList.remove('hidden');
        if (noAlerts) noAlerts.classList.add('hidden');

        if (cards) {
            cards.innerHTML = alertEmployees.map(row => {
                const info = calculateCycleInfo(row.admissao);
                const isUrgent = info.isUrgent;
                const pct = Math.min(100, ((365 - info.daysRemaining) / 365) * 100);

                return `
                    <div class="alert-card ${isUrgent ? 'urgent' : ''}">
                        <div class="ac-header">
                            <div>
                                <div class="ac-name">${row.nome}</div>
                                <div class="ac-setor">${normalizeDepartment(row.dept)} · ${row.cargo || '—'}</div>
                            </div>
                            <div class="ac-badge">${info.daysRemaining}d</div>
                        </div>
                        <div class="ac-progress">
                            <div class="${isUrgent ? 'ac-bar-urgent' : 'ac-bar-warn'}" style="width:${pct}%"></div>
                        </div>
                        <div class="ac-footer">
                            <span class="ac-adm">Adm: ${formatDate(row.admissao)}</span>
                            <span class="ac-aniv">${info.cycleNumber}º ciclo vence em ${info.nextAniv.toLocaleDateString('pt-BR')}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    // Render Cadastro table
    function renderCadastro() {
        const tbody = document.getElementById('cadastro-tbody');
        if (!tbody) return;

        tbody.innerHTML = rows.slice(0, 20).map(row => {
            const info = calculateCycleInfo(row.admissao);
            const hasVacation = !!row.di;

            return `
                <tr>
                    <td>${row.id_f}</td>
                    <td class="nome-col">
                        <span class="avatar" style="background:${getAvatarBg(row.nome)}">${getInitials(row.nome)}</span>
                        ${row.nome}
                    </td>
                    <td>${row.cargo || '—'}</td>
                    <td>${normalizeDepartment(row.dept)}</td>
                    <td>${formatDate(row.admissao)}</td>
                    <td>${renderCycleBar(row.admissao, hasVacation)}</td>
                    <td><span class="${statusBadgeClass(row.status)}">${row.status}</span></td>
                </tr>
            `;
        }).join('');
    }

    // Render Charts
    function renderCharts() {
        if (typeof Chart === 'undefined') return;

        // Status Doughnut Chart
        const statusCtx = document.getElementById('chart-status');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aprovada', 'Em Análise', 'Pendente', 'Reprovada'],
                    datasets: [{
                        data: [kpis.approved, kpis.in_review, kpis.pending, rows.filter(r => r.status === 'Reprovada').length],
                        backgroundColor: ['rgba(34,211,160,.7)', 'rgba(56,189,248,.7)', 'rgba(251,146,60,.7)', 'rgba(248,113,113,.7)'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: { color: '#94a3b8', font: { size: 10 } }
                        }
                    }
                }
            });
        }

        // Months Bar Chart
        const monthsCtx = document.getElementById('chart-months');
        if (monthsCtx) {
            const monthLabels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            const monthCounts = new Array(12).fill(0);

            rows.forEach(row => {
                if (row.di) {
                    const monthIdx = Number(row.di.split('-')[1]) - 1;
                    monthCounts[monthIdx]++;
                }
            });

            new Chart(monthsCtx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        data: monthCounts,
                        backgroundColor: monthCounts.map((_, i) => {
                            const hue = 180 + (i * 15);
                            return `hsla(${hue}, 70%, 55%, 0.7)`;
                        }),
                        borderRadius: 4,
                        borderSkipped: false
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9 } } },
                        y: { grid: { color: 'rgba(255,255,255,.05)' }, ticks: { color: '#64748b', font: { size: 9 } } }
                    }
                }
            });
        }

        // Coverage list
        const coverageList = document.getElementById('coverage-list');
        if (coverageList) {
            const withCoverage = rows.filter(r => r.cobertura);
            coverageList.innerHTML = withCoverage.slice(0, 5).map(row => `
                <div style="padding:8px;border-bottom:1px solid rgba(255,255,255,.05);font-size:11px">
                    <strong style="color:var(--text)">${row.nome}</strong>
                    <div style="color:var(--muted);margin-top:2px">${row.cobertura}</div>
                </div>
            `).join('') || '<div style="padding:16px;text-align:center;color:var(--muted);font-size:11px">Nenhuma cobertura registrada</div>';
        }
    }

    // Event Listeners
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            chips.forEach(c => c.classList.remove('on'));
            chip.classList.add('on');
            currentFilter = chip.dataset.status;
            currentPage = 1;
            renderProgramacao();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentSearch = searchInput.value;
            currentPage = 1;
            renderProgramacao();
        });
    }

    if (monthSelect) {
        monthSelect.addEventListener('change', () => {
            currentMonth = monthSelect.value;
            currentPage = 1;
            renderProgramacao();
        });
    }

    if (departmentSelect) {
        departmentSelect.addEventListener('change', () => {
            currentDepartment = departmentSelect.value;
            currentPage = 1;
            renderProgramacao();
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            currentFilter = '';
            currentMonth = '';
            currentDepartment = '';
            currentSearch = '';
            currentPage = 1;

            chips.forEach(c => c.classList.remove('on'));
            root.querySelector('.chip.all')?.classList.add('on');
            if (searchInput) searchInput.value = '';
            if (monthSelect) monthSelect.value = '';
            if (departmentSelect) departmentSelect.value = '';

            renderProgramacao();
        });
    }

    // Modal handlers
    function openModal(employeeId = null) {
        const title = document.getElementById('modal-title');
        if (title) title.textContent = employeeId ? 'Editar Funcionário' : 'Novo Funcionário';

        if (employeeId) {
            const emp = rows.find(r => r.id === employeeId);
            if (emp) {
                document.getElementById('employee-id').value = emp.id;
                document.getElementById('employee-name').value = emp.nome;
                document.getElementById('employee-job').value = emp.cargo || '';
                document.getElementById('employee-hired').value = emp.admissao || '';
                if (emp.di) document.getElementById('vacation-start').value = emp.di;
                if (emp.df) document.getElementById('vacation-end').value = emp.df;
                document.getElementById('vacation-coverage').value = emp.cobertura || '';
            }
        } else {
            employeeForm?.reset();
        }

        modal?.classList.add('open');
    }

    function closeModal() {
        modal?.classList.remove('open');
        employeeForm?.reset();
        document.getElementById('adm-preview')?.classList.remove('show');
    }

    addBtns.forEach(btn => btn?.addEventListener('click', () => openModal()));
    cancelBtn?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Hired date preview
    const hiredInput = document.getElementById('employee-hired');
    const admPreview = document.getElementById('adm-preview');

    if (hiredInput && admPreview) {
        hiredInput.addEventListener('change', () => {
            const info = calculateCycleInfo(hiredInput.value);
            if (info) {
                admPreview.classList.add('show');
                document.getElementById('adm-ciclo').textContent = `${info.cycleNumber}º ciclo`;
                document.getElementById('adm-aniv').textContent = info.nextAniv.toLocaleDateString('pt-BR');

                const diasEl = document.getElementById('adm-dias');
                diasEl.textContent = `${info.daysRemaining} dias`;
                diasEl.className = 'adm-val ' + (info.isUrgent ? 'c-urgent' : info.isWarning ? 'c-warn' : 'c-ok');
            } else {
                admPreview.classList.remove('show');
            }
        });
    }

    // Form submit
    if (employeeForm) {
        employeeForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(employeeForm);
            const data = Object.fromEntries(formData.entries());

            // Here you would send to the API
            console.log('Form data:', data);
            alert('Funcionalidade de salvar será implementada com a API');
            closeModal();
        });
    }

    // Edit/Delete buttons
    root.addEventListener('click', (e) => {
        const editBtn = e.target.closest('.btn-edit');
        const delBtn = e.target.closest('.btn-del');

        if (editBtn) {
            const id = parseInt(editBtn.dataset.id);
            openModal(id);
        }

        if (delBtn) {
            const id = delBtn.dataset.id;
            if (confirm('Tem certeza que deseja excluir este funcionário?')) {
                console.log('Delete employee:', id);
                alert('Funcionalidade de excluir será implementada com a API');
            }
        }
    });

    // KPI card clicks
    root.querySelectorAll('.kpi-card[data-filter], .seg-card[data-filter]').forEach(card => {
        card.addEventListener('click', () => {
            const filter = card.dataset.filter;
            currentFilter = filter;
            currentPage = 1;

            chips.forEach(c => c.classList.remove('on'));
            root.querySelector(`.chip[data-status="${filter}"]`)?.classList.add('on');

            // Switch to programacao tab
            root.querySelector('[data-tab-target="programacao"]')?.click();

            renderProgramacao();
        });
    });

    // Date chip
    const dateChip = document.getElementById('date-chip');
    if (dateChip) {
        dateChip.textContent = new Date().toLocaleDateString('pt-BR', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    // Initial render
    updateKPIs();
    renderProgramacao();
    renderCalendar();
    renderAlerts();
    renderCadastro();
    renderCharts();
}
