<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedTinyInteger('day');
            $table->string('status', 4); // P, FO, FJ, FI, FE, S
            $table->string('obs', 255)->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'year', 'month', 'day']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
