<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Cria 3 colaboradores fictícios
            $employees = [
                ['name' => 'Ana Souza'],
                ['name' => 'Carlos Lima'],
                ['name' => 'Beatriz Silva'],
            ];
            foreach ($employees as &$emp) {
                $emp['id'] = Employee::factory()->create(['name' => $emp['name']])->id;
            }

            $statuses = ['P', 'FO', 'FJ', 'FI', 'FE', 'S'];
            $year = 2026;
            $month = 3;
            $daysInMonth = 31;

            // Escala: alterna status para cada colaborador
            foreach ($employees as $i => $emp) {
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    Schedule::create([
                        'employee_id' => $emp['id'],
                        'year' => $year,
                        'month' => $month,
                        'day' => $d,
                        'status' => $statuses[($i + $d) % count($statuses)],
                        'obs' => null,
                    ]);
                }
            }

            // Ausências de exemplo
            Absence::create([
                'employee_id' => $employees[0]['id'],
                'date' => "$year-$month-05",
                'type' => 'FJ',
                'reason' => 'Atestado médico',
            ]);
            Absence::create([
                'employee_id' => $employees[1]['id'],
                'date' => "$year-$month-10",
                'type' => 'FI',
                'reason' => 'Falta não justificada',
            ]);
            Absence::create([
                'employee_id' => $employees[2]['id'],
                'date' => "$year-$month-15",
                'type' => 'S',
                'reason' => 'Suspensão disciplinar',
            ]);
        });
    }
}
