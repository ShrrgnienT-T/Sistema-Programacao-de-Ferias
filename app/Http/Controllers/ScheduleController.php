<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Employee;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
  public function index(Request $request)
  {
    $year = $request->input('year', now()->year);
    $month = $request->input('month', now()->month);
    $employees = Employee::with([
      'schedules' => function ($q) use ($year, $month) {
        $q->where('year', $year)->where('month', $month);
      }
    ])->get();
    return view('schedule.index', compact('employees', 'year', 'month'));
  }

  public function update(Request $request)
  {
    $data = $request->validate([
      'employee_id' => 'required|exists:employees,id',
      'year' => 'required|integer',
      'month' => 'required|integer',
      'day' => 'required|integer',
      'status' => 'required|string',
      'obs' => 'nullable|string',
    ]);
    $schedule = Schedule::updateOrCreate(
      [
        'employee_id' => $data['employee_id'],
        'year' => $data['year'],
        'month' => $data['month'],
        'day' => $data['day'],
      ],
      [
        'status' => $data['status'],
        'obs' => $data['obs'] ?? null,
      ]
    );
    return response()->json(['success' => true, 'schedule' => $schedule]);
  }

  // Métodos para ações rápidas, geração automática, etc. podem ser adicionados aqui
}
