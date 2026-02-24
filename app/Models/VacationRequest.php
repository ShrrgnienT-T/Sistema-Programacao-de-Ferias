<?php

namespace App\Models;

use App\Enums\VacationRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationRequest extends Model
{
    /** @use HasFactory<\Database\Factories\VacationRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'starts_at',
        'ends_at',
        'days_requested',
        'status',
        'coverage_notes',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'approved_at' => 'datetime',
            'days_requested' => 'integer',
            'status' => VacationRequestStatus::class,
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', VacationRequestStatus::Approved);
    }

    public function scopeInReview(Builder $query): Builder
    {
        return $query->where('status', VacationRequestStatus::InReview);
    }
}
