<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacation_balance_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('adjusted_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('previous_balance_days', 5, 2);
            $table->decimal('new_balance_days', 5, 2);
            $table->decimal('delta_days', 5, 2);
            $table->string('reason', 500);
            $table->timestamps();

            $table->index(['employee_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacation_balance_adjustments');
    }
};
