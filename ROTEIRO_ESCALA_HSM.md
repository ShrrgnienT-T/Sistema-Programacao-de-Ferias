# Roteiro de Integração do Módulo Escala HSM ao Sistema de Programação de Férias

## 1. Análise das Funcionalidades do HTML

### Funcionalidades Identificadas

1. **Navegação de Meses**
   - Troca de mês para visualizar a escala de outro período.
2. **Visualização de Escala**
   - Tabela dinâmica com dias do mês, nomes dos colaboradores, siglas de status (P, FO, FJ, FI, FE, S), cores e legendas.
   - Totais por colaborador e por tipo de status.
3. **Filtros e Busca**
   - Filtros por nome, setor, cargo, status, etc.
4. **Dashboard Estatístico**
   - Cards com estatísticas (presenças, faltas, férias, etc.).
   - Gráficos e rankings.
5. **Gestão de Colaboradores**
   - Modal para visualizar/editar dados do colaborador.
   - Adição/remoção de colaboradores.
6. **Gestão de Escala**
   - Edição de status de cada dia (presença, falta, férias, etc.).
   - Context menu para ações rápidas.
7. **Gestão de Férias**
   - Visualização e controle de férias (status: análise, confirmado, gozo, concluído).
8. **Gestão de Desligados**
   - Visualização de colaboradores desligados.
9. **Tema Claro/Escuro**
   - Alternância de tema.
10. **Responsividade e UX**
    - Interface adaptável, tooltips, feedback visual.

---

## 2. Roteiro de Implementação e Separação de Responsabilidades

### 2.1. Models (PHP)

- **Employee**
  Representa o colaborador, com relações para setor, cargo, status, férias, desligamento, etc.
- **Department**
  Setores/departamentos.
- **JobTitle**
  Cargos/funções.
- **VacationRequest**
  Solicitações de férias.
- **VacationBalanceAdjustment**
  Ajustes de saldo de férias.
- **Schedule (Escala)**
  Nova model para armazenar a escala de cada colaborador por dia/mês.
- **Absence**
  Faltas justificadas/injustificadas, suspensões, etc.

### 2.2. Controllers (PHP)

- **ScheduleController**
  CRUD da escala, geração automática, edição manual, visualização por mês.
- **EmployeeController**
  CRUD de colaboradores, filtro, busca, modal de edição.
- **DashboardController**
  Estatísticas, gráficos, rankings.
- **VacationController**
  Gestão de férias, status, integração com escala.
- **AbsenceController**
  Gestão de faltas, suspensões, etc.
- **SettingsController**
  Preferências do usuário (tema, etc.).

### 2.3. Views (Blade)

- **schedule/index.blade.php**
  Tabela principal da escala, navegação de meses, filtros, legendas.
- **schedule/_table.blade.php**
  Parcial para tabela de escala.
- **schedule/_filters.blade.php**
  Parcial para filtros.
- **dashboard/index.blade.php**
  Cards, gráficos, rankings.
- **employee/_modal.blade.php**
  Modal de edição/visualização de colaborador.
- **vacation/_row.blade.php**
  Linha de férias por colaborador.
- **desligados/index.blade.php**
  Lista de colaboradores desligados.

### 2.4. Componentes JS (Vue/Alpine/Vanilla)

- **MonthNav**
  Componente para navegação de meses.
- **ScheduleTable**
  Renderização dinâmica da tabela de escala, edição inline, tooltips.
- **FiltersBar**
  Filtros dinâmicos.
- **StatCards**
  Cards de estatísticas.
- **DashboardCharts**
  Gráficos e rankings.
- **EmployeeModal**
  Modal de colaborador.
- **VacationRow**
  Linha de férias.
- **ContextMenu**
  Menu de contexto para ações rápidas.
- **ThemeToggle**
  Alternância de tema claro/escuro.

### 2.5. Rotas (web.php)

- GET /escala → ScheduleController@index
- POST /escala/atualizar → ScheduleController@update
- GET /dashboard → DashboardController@index
- GET /colaboradores → EmployeeController@index
- POST /colaboradores/editar → EmployeeController@update
- GET /ferias → VacationController@index
- POST /ferias/atualizar → VacationController@update
- GET /desligados → EmployeeController@disconnected
- POST /escala/acao-rapida → ScheduleController@quickAction

### 2.6. Serviços e Jobs

- **ScheduleGeneratorService**
  Geração automática da escala.
- **VacationSyncService**
  Sincronização de férias com a escala.
- **AbsenceSyncService**
  Sincronização de faltas/suspensões.

### 2.7. Policies e Gates

- Controle de permissões para edição de escala, férias, desligamento, etc.

### 2.8. Testes

- Testes de integração para geração de escala, edição, filtros, etc.
- Testes unitários para models e serviços.

---

## 3. Integrações e Fluxo de Dados

- **Frontend**:
  - JS consome endpoints REST/JSON para atualização dinâmica (AJAX).
  - Utilização de componentes reativos para UX fluida.
- **Backend**:
  - Controllers retornam JSON para ações assíncronas e Blade para renderização inicial.
  - Models com relações Eloquent para fácil consulta.
- **Banco de Dados**:
  - Tabelas: employees, departments, job_titles, schedules, absences, vacations, vacation_balance_adjustments, etc.

---

## 4. Resumo Visual de Responsabilidades

```mermaid
graph TD
  A[ScheduleController] -->|GET escala| B[ScheduleTable (Blade/JS)]
  B -->|Edição| A
  A -->|JSON| B
  A -->|Geração| F[ScheduleGeneratorService]
  A -->|Sincronização| G[VacationSyncService]
  C[EmployeeController] -->|GET/POST| D[EmployeeModal]
  H[DashboardController] -->|GET| I[StatCards/DashboardCharts]
  J[VacationController] -->|GET/POST| K[VacationRow]
  L[AbsenceController] -->|GET/POST| M[Absence]
  N[SettingsController] -->|Tema| O[ThemeToggle]
```

---

## 5. Checklist de Implementação

1. Criar migrations para tabela de escala e ausências.
2. Implementar models Schedule e Absence.
3. Criar controllers e rotas.
4. Implementar views Blade e componentes JS.
5. Integrar frontend com backend via AJAX.
6. Implementar serviços de geração/sincronização.
7. Adicionar testes.
8. Documentar permissões e políticas.
9. Garantir responsividade e acessibilidade.

---

Se quiser o detalhamento de cada componente, controller, model ou view, posso expandir cada item do roteiro!
