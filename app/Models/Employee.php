<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'job_title',
        'hired_at',
        'vacation_days_per_year',
        'vacation_balance_days',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'hired_at' => 'date',
            'vacation_days_per_year' => 'integer',
            'vacation_balance_days' => 'decimal:2',
            'status' => EmployeeStatus::class,
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function vacationRequests(): HasMany
    {
        return $this->hasMany(VacationRequest::class);
    }

    public function vacationBalanceAdjustments(): HasMany
    {
        return $this->hasMany(VacationBalanceAdjustment::class);
    }

    public function latestVacationRequest(): HasOne
    {
        return $this->hasOne(VacationRequest::class)->latestOfMany('starts_at');
    }
}
