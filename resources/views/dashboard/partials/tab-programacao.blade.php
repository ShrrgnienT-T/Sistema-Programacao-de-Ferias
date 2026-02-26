<div class="tab" id="tab-programacao">
   <!-- Filter Bar -->
   <div class="filter-bar">
      <span class="filter-label">Filtros</span>

      <div class="chip-group">
         <button class="chip all on" data-status="">Todos</button>
         <button class="chip aprov" data-status="Aprovada">✅ Aprovadas</button>
         <button class="chip anali" data-status="Em Análise">🔍 Em Análise</button>
         <button class="chip pend" data-status="Pendente">⏳ Pendentes</button>
      </div>

      <select class="filter-select" id="programacao-month">
         <option value="">📆 Todos os Meses</option>
         @foreach ($planningMonths as $month)
            <option value="{{ $month }}">{{ $month }}</option>
         @endforeach
      </select>

      <select class="filter-select" id="programacao-department">
         <option value="">🏢 Todos os Departamentos</option>
      </select>

      <input class="table-search" id="programacao-search" placeholder="🔍 Buscar colaborador...">

      <span class="filter-count" id="filter-count">0 registros</span>
      <button class="btn-clear" id="btn-clear-filters">✕ Limpar</button>
   </div>

   <!-- Table -->
   <div class="table-card">
      <div class="table-header">
         <span class="section-sub mb-0">Lista completa de programações de férias</span>
         <button class="btn-add" id="btn-add-employee">➕ Novo Funcionário</button>
      </div>
      <div class="table-wrap">
         <table>
            <thead>
               <tr>
                  <th>#</th>
                  <th>Colaborador</th>
                  <th>Cargo</th>
                  <th>Departamento</th>
                  <th>Ciclo Adm.</th>
                  <th>Mês Prev.</th>
                  <th>Período</th>
                  <th>Dias</th>
                  <th>Status</th>
                  <th>Ações</th>
               </tr>
            </thead>
            <tbody id="programacao-tbody"></tbody>
         </table>
      </div>
      <div class="pagination" id="pagination">
         <span id="pagination-info">Mostrando 0 de 0</span>
         <div class="pg-btns" id="pagination-btns"></div>
      </div>
   </div>
</div>
