<div class="tab active" id="tab-dashboard">
    <!-- KPIs Grid -->
    <div class="kpi-grid">
        <div class="kpi-card neutral">
            <div class="kpi-top">
                <span class="kpi-icon">👥</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-total">0</div>
            <div class="kpi-label">Total Cadastrados</div>
        </div>
        <div class="kpi-card aprov" data-filter="Aprovada">
            <div class="kpi-top">
                <span class="kpi-icon">✅</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-aprov">0</div>
            <div class="kpi-label">Aprovadas</div>
            <div class="kpi-hint">Clique para filtrar</div>
        </div>
        <div class="kpi-card anali" data-filter="Em Análise">
            <div class="kpi-top">
                <span class="kpi-icon">🔍</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-anali">0</div>
            <div class="kpi-label">Em Análise</div>
            <div class="kpi-hint">Clique para filtrar</div>
        </div>
        <div class="kpi-card pend" data-filter="Pendente">
            <div class="kpi-top">
                <span class="kpi-icon">⏳</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-pend">0</div>
            <div class="kpi-label">Pendentes</div>
            <div class="kpi-hint">Clique para filtrar</div>
        </div>
        <div class="kpi-card danger">
            <div class="kpi-top">
                <span class="kpi-icon">📋</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-empty">0</div>
            <div class="kpi-label">Sem Programação</div>
        </div>
        <div class="kpi-card warn-card" id="kpi-alerts-card">
            <div class="kpi-top">
                <span class="kpi-icon">⚠️</span>
                <span class="kpi-dot"></span>
            </div>
            <div class="kpi-val" id="kpi-alerts">0</div>
            <div class="kpi-label">Alertas de Ciclo</div>
            <div class="kpi-hint">Funcionários em prazo</div>
        </div>
    </div>

    <!-- Segmentation Panel -->
    <div class="seg-panel">
        <div class="seg-title">Segmentação por Status</div>
        <div class="seg-grid">
            <div class="seg-card aprov" data-filter="Aprovada">
                <div class="seg-header">
                    <span class="seg-name">✅ Aprovadas</span>
                    <span class="seg-count" id="seg-aprov">0</span>
                </div>
                <div class="seg-bar-wrap">
                    <span class="seg-bar" id="seg-bar-aprov" style="width:0%"></span>
                </div>
                <div class="seg-pct">
                    <span id="seg-pct-aprov">0%</span>
                    <span class="seg-hint">do total</span>
                </div>
            </div>
            <div class="seg-card anali" data-filter="Em Análise">
                <div class="seg-header">
                    <span class="seg-name">🔍 Em Análise</span>
                    <span class="seg-count" id="seg-anali">0</span>
                </div>
                <div class="seg-bar-wrap">
                    <span class="seg-bar" id="seg-bar-anali" style="width:0%"></span>
                </div>
                <div class="seg-pct">
                    <span id="seg-pct-anali">0%</span>
                    <span class="seg-hint">do total</span>
                </div>
            </div>
            <div class="seg-card pend" data-filter="Pendente">
                <div class="seg-header">
                    <span class="seg-name">⏳ Pendentes</span>
                    <span class="seg-count" id="seg-pend">0</span>
                </div>
                <div class="seg-bar-wrap">
                    <span class="seg-bar" id="seg-bar-pend" style="width:0%"></span>
                </div>
                <div class="seg-pct">
                    <span id="seg-pct-pend">0%</span>
                    <span class="seg-hint">do total</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <div class="chart-card">
            <div class="chart-title">Distribuição por Status</div>
            <canvas id="chart-status"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-title">Programação por Mês</div>
            <canvas id="chart-months"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-title">Cobertura</div>
            <div id="coverage-list" class="coverage-list"></div>
        </div>
    </div>
</div>
