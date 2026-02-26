<div class="tab" id="tab-programacao">
    <div class="filter-bar">
        <input class="table-search" id="programacao-search" placeholder="🔍 Buscar colaborador...">
        <select class="filter-select" id="programacao-status">
            <option value="">Todos status</option>
            <option value="Aprovada">Aprovada</option>
            <option value="Em Análise">Em Análise</option>
            <option value="Pendente">Pendente</option>
            <option value="Reprovada">Reprovada</option>
        </select>
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>Colaborador</th><th>Cargo</th><th>Departamento</th><th>Admissão</th><th>Início</th><th>Fim</th><th>Dias</th><th>Status</th>
                    </tr>
                </thead>
                <tbody id="programacao-tbody"></tbody>
            </table>
        </div>
    </div>
</div>
