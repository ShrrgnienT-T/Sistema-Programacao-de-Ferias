<div class="tabs-nav">
   <button class="nav-btn active" data-tab-target="dashboard">📊 Dashboard</button>
   <button class="nav-btn" data-tab-target="programacao">
      📋 Programação
      <span class="nav-badge nb-blue" id="badge-programacao">0</span>
   </button>
   <button class="nav-btn" data-tab-target="calendario">📅 Calendário</button>
   <button class="nav-btn warn-tab" data-tab-target="cadastro">
      👤 Cadastro
      <span class="nav-badge nb-warn hidden" id="badge-alerts">0</span>
   </button>
</div>

<!-- Modal Background -->
<div class="modal-bg" id="modal-employee">
   <div class="modal">
      <div class="modal-title" id="modal-title">Novo Funcionário</div>
      <div class="modal-sub">Preencha os dados para cadastro</div>

      <form id="form-employee">
         <input type="hidden" id="employee-id" name="id">

         <div class="modal-section">Dados Pessoais</div>
         <div class="form-grid">
            <div class="form-group full">
               <label for="employee-name">Nome Completo *</label>
               <input type="text" id="employee-name" name="name" required placeholder="Nome do funcionário">
            </div>
            <div class="form-group">
               <label for="employee-job">Cargo *</label>
               <select id="employee-job" name="job_title" required>
                  <option value="">Selecione...</option>
                  @foreach (\App\Enums\EmployeeJobTitle::cases() as $title)
                     <option value="{{ $title->value }}">{{ $title->label() }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group">
               <label for="employee-dept">Departamento *</label>
               <select id="employee-dept" name="department_id" required>
                  <option value="">Selecione...</option>
               </select>
            </div>
         </div>

         <div class="modal-section">Dados Contratuais</div>
         <div class="form-grid">
            <div class="form-group">
               <label for="employee-hired">Data de Admissão *</label>
               <input type="date" id="employee-hired" name="hired_at" required>
            </div>
            <div class="form-group">
               <label for="employee-days">Dias de Férias/Ano</label>
               <input type="number" id="employee-days" name="vacation_days_per_year" value="30" min="0"
                  max="60">
            </div>
         </div>

         <!-- Admissão Preview Box -->
         <div class="adm-box" id="adm-preview">
            <div class="adm-row">
               <span class="adm-lbl">Ciclo Aquisitivo</span>
               <span class="adm-val" id="adm-ciclo">—</span>
            </div>
            <div class="adm-row">
               <span class="adm-lbl">Próximo Aniversário</span>
               <span class="adm-val" id="adm-aniv">—</span>
            </div>
            <div class="adm-row">
               <span class="adm-lbl">Dias Restantes</span>
               <span class="adm-val" id="adm-dias">—</span>
            </div>
         </div>

         <div class="modal-section">Programação de Férias (Opcional)</div>
         <div class="form-grid">
            <div class="form-group">
               <label for="vacation-start">Data de Início</label>
               <input type="date" id="vacation-start" name="vacation_starts_at">
            </div>
            <div class="form-group">
               <label for="vacation-end">Data de Fim</label>
               <input type="date" id="vacation-end" name="vacation_ends_at">
            </div>
            <div class="form-group full">
               <label for="vacation-coverage">Cobertura / Observações</label>
               <textarea id="vacation-coverage" name="coverage_notes" rows="2"
                  placeholder="Quem vai cobrir durante as férias..."></textarea>
            </div>
         </div>

         <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn-cancel" id="btn-cancel-modal">Cancelar</button>
            <button type="submit" class="btn-save">💾 Salvar</button>
         </div>
      </form>
   </div>
</div>
