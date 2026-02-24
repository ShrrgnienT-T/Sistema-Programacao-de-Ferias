# Sistema de Programação de Férias

Base inicial do projeto em **Laravel 12 + Breeze (Blade)** com layout administrativo em **AdminLTE**, mantendo **TailwindCSS** para componentes específicos.

## Stack do MVP

- Laravel 12.x
- PHP 8.4+
- MySQL (produção) / SQLite (local rápido)
- Blade + Alpine.js
- AdminLTE (layout principal)
- TailwindCSS (componentes isolados)

## Estado atual (EPIC 1)

- Projeto Laravel criado e pronto para desenvolvimento.
- Autenticação Breeze instalada (login, registro, perfil, reset de senha).
- Layout `x-app-layout` migrado para estrutura AdminLTE.
- Componentes Blade reutilizáveis adicionados:
  - `x-ui.card`
  - `x-ui.badge`
  - `x-ui.button`
  - `x-ui.table`
- Dashboard inicial ajustado para usar os componentes e servir como base das próximas métricas.

## Próximos passos recomendados

1. Modelagem de banco (`departments`, `employees`, `vacation_requests`, `vacation_balance_adjustments`).
2. Definir policy de ajuste manual de saldo e trilha de auditoria obrigatória.
3. Criar enum de status e actions de workflow (`approve/reject/review`).
4. Evoluir dashboard para métricas reais por query dedicada.

## Ponto de atenção (decisão de negócio)

Você escolheu **saldo editável manualmente**. Isso pode atender o legado da planilha, mas exige governança para não virar inconsistência de dados.

Mínimo recomendado:

- ajuste somente por perfis autorizados;
- registro obrigatório de motivo;
- log imutável de ajuste (`before`, `after`, `delta`, `actor`, `timestamp`);
- exibição clara de "saldo calculado" x "saldo ajustado" na UI.

Sem isso, o custo de suporte tende a crescer rápido.
