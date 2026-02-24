# Sistema de Programação de Férias

Sistema web em Laravel para programação, aprovação e acompanhamento de férias, com foco em entrega incremental e governança de dados.

## Stack

- Laravel 12.x
- Blade + Alpine.js
- AdminLTE (layout principal)
- TailwindCSS (componentes específicos)
- MySQL (produção) / SQLite (dev rápido)

## Progresso por épico

### ✅ EPIC 1 — Setup & Fundação

- Projeto Laravel + Breeze (Blade)
- Layout base AdminLTE
- Componentes Blade reutilizáveis (`x-ui.card`, `x-ui.badge`, `x-ui.button`, `x-ui.table`)

### ✅ EPIC 2 — Modelagem de Banco (fase 1)

- Migrations criadas para:
  - `departments`
  - `employees`
  - `vacation_requests`
  - `vacation_balance_adjustments`
- Enums de domínio:
  - `EmployeeStatus`
  - `VacationRequestStatus`
- Relacionamentos Eloquent e casts aplicados
- Factories e seeder base para dados de desenvolvimento
- Teste de schema e relacionamentos do domínio

## Decisão importante: saldo manual editável

Saldo manual **só é aceitável com trilha de auditoria forte**. Este projeto já cria base para isso com `vacation_balance_adjustments`.

Mínimo obrigatório nas próximas entregas:

1. Ajuste de saldo via Action dedicada (nunca update direto em controller)
2. Policy para limitar quem ajusta saldo
3. Motivo obrigatório e histórico imutável
4. Tela mostrando saldo atual + histórico de ajustes

## Próximos passos (EPIC 3)

- CRUD de colaboradores com filtros por departamento e status
- Form Requests para create/update
- Action `AdjustEmployeeVacationBalanceAction`
- Testes de autorização e trilha de ajuste
