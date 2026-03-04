<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');
            $table->enum('type', ['FJ', 'FI', 'S']); // FJ: Justificada, FI: Injustificada, S: Suspensão
            $table->string('reason', 255)->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
