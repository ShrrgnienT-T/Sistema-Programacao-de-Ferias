# EPIC Status

## EPIC 2 (implemented)

- Domain enums:
  - `App\Enums\EmployeeStatus`
  - `App\Enums\VacationRequestStatus`
- Domain schema migrations:
  - `departments`
  - `employees`
  - `vacation_requests`
  - `vacation_balance_adjustments`
- Eloquent domain models and relationships:
  - `Department`, `Employee`, `VacationRequest`, `VacationBalanceAdjustment`
- Domain factories and schema tests:
  - `tests/Feature/Database/VacationDomainSchemaTest.php`

## EPIC 3 (implemented)

- Employee resource routes and controller:
  - `App\Http\Controllers\EmployeeController`
- Employee Form Requests:
  - `App\Http\Requests\StoreEmployeeRequest`
  - `App\Http\Requests\UpdateEmployeeRequest`
- AdminLTE Blade views for employee CRUD:
  - `resources/views/employees/*`
- Employee navigation entry in sidebar:
  - `resources/views/layouts/app.blade.php`
- Feature tests for employee CRUD and permissions:
  - `tests/Feature/Employees/EmployeeCrudTest.php`


## EPIC 4+ (in progress)

- Dashboard migrated to Morhena operational layout with tabs (Dashboard/Programação/Calendário/Cadastro) backed by real domain data:
  - `App\Http\Controllers\DashboardController`
  - `resources/views/dashboard.blade.php`
- Added `Employee::latestVacationRequest()` relation to support read model composition.
- Added feature tests for dashboard permission and rendering:
  - `tests/Feature/Dashboard/DashboardViewTest.php`

## Why this file exists

`README.md`, `app/Models/User.php`, and `database/seeders/DatabaseSeeder.php` are high-conflict hotspots in collaborative repos.
To reduce merge friction, project-status notes are tracked here instead of competing edits in README.
