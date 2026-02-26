<div class="tab" id="tab-cadastro">
    <!-- Alert Banner -->
    <div class="alert-banner" id="alert-banner">
        <div class="alert-banner-icon">🔔</div>
        <div class="alert-banner-body">
            <div class="alert-banner-title">Alertas de Ciclo Aquisitivo</div>
            <div class="alert-banner-sub">Funcionários que precisam programar férias antes do vencimento do ciclo</div>
        </div>
        <div class="alert-banner-count" id="alert-count">0</div>
    </div>

    <!-- Alert Cards -->
    <div class="alert-cards" id="alert-cards">
        <!-- Populated by JS -->
    </div>

    <!-- No Alerts Message -->
    <div class="no-alerts hidden" id="no-alerts">
        <div class="no-alerts-icon">✨</div>
        <div class="no-alerts-title">Tudo em dia!</div>
        <div class="no-alerts-sub">Não há funcionários com ciclo aquisitivo vencendo em breve.</div>
    </div>

    <!-- Employee Full Table -->
    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="section-title mb-0">Cadastro de Funcionários</div>
                <div class="section-sub mb-0">Lista completa de funcionários</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm">Ver cadastro completo →</a>
                <button class="btn-add" id="btn-add-employee-cadastro">➕ Novo Funcionário</button>
            </div>
        </div>
        <div class="table-wrap" style="max-height:350px">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th>Admissão</th>
                        <th>Ciclo Atual</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="cadastro-tbody"></tbody>
            </table>
        </div>
    </div>
</div>
