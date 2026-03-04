<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AbsenceController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('employees', EmployeeController::class);

    // Rotas da escala
    Route::get('/escala', [ScheduleController::class, 'index'])->name('escala.index');
    Route::post('/escala/atualizar', [ScheduleController::class, 'update'])->name('escala.update');

    // Rotas de ausências
    Route::post('/ausencias', [AbsenceController::class, 'store'])->name('ausencias.store');
    Route::delete('/ausencias/{id}', [AbsenceController::class, 'destroy'])->name('ausencias.destroy');
});

require __DIR__ . '/auth.php';
