<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'day',
        'status',
        'obs',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
