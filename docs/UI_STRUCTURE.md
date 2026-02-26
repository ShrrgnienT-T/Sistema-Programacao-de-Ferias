# UI Structure (Morhena Layout)

## Layout (global shell)
- `resources/views/layouts/app.blade.php`
  - Defines the global HTML shell (`<header>`, `<main>`) and default visual identity.
  - Shared across authenticated pages via `x-app-layout`.

## Partials (view composition)
- `resources/views/partials/morhena/header.blade.php`
  - Top bar (logo, navigation, date chip, logout).
- `resources/views/dashboard/partials/*`
  - `tabs.blade.php`, `tab-dashboard.blade.php`, `tab-programacao.blade.php`, `tab-calendario.blade.php`, `tab-cadastro.blade.php`.
  - Keep each dashboard section isolated and easier to evolve.

## JS Components (behavior)
- `resources/js/components/morhena/tabs.js`
  - Tab switching behavior.
- `resources/js/components/morhena/dashboard.js`
  - Dashboard rendering (KPIs, programação table filtering, calendar rendering, chart setup).

## Styles
- `resources/css/morhena.css`
  - Centralized theme (tokens, layout, table/chart/tab/button primitives).
- Imported in `resources/css/app.css`.

## Why this split
- Layout controls skeleton.
- Partials control server-rendered HTML composition.
- JS components control interactive behavior.
- Avoids one giant Blade file and avoids inline mega scripts.
