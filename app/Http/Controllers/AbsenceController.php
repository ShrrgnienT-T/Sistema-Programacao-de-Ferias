<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'type' => 'required|in:FJ,FI,S',
            'reason' => 'nullable|string',
        ]);
        $absence = Absence::create($data);
        return response()->json(['success' => true, 'absence' => $absence]);
    }

    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();
        return response()->json(['success' => true]);
    }
}
