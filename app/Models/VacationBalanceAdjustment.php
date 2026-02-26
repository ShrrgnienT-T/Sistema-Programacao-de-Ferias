<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationBalanceAdjustment extends Model
{
    /** @use HasFactory<\Database\Factories\VacationBalanceAdjustmentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'adjusted_by',
        'previous_balance_days',
        'new_balance_days',
        'delta_days',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'previous_balance_days' => 'decimal:2',
            'new_balance_days' => 'decimal:2',
            'delta_days' => 'decimal:2',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function adjustedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }
}
