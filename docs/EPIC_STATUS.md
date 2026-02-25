# EPIC Status

## EPIC 2 (implemented)

- Domain enums:
  - `App\\Enums\\EmployeeStatus`
  - `App\\Enums\\VacationRequestStatus`
- Domain schema migrations:
  - `departments`
  - `employees`
  - `vacation_requests`
  - `vacation_balance_adjustments`
- Eloquent domain models and relationships:
  - `Department`, `Employee`, `VacationRequest`, `VacationBalanceAdjustment`
- Domain factories and schema tests:
  - `tests/Feature/Database/VacationDomainSchemaTest.php`

## Why this file exists

`README.md`, `app/Models/User.php`, and `database/seeders/DatabaseSeeder.php` are high-conflict hotspots in collaborative repos.
To reduce merge friction, project-status notes are tracked here instead of competing edits in README.
