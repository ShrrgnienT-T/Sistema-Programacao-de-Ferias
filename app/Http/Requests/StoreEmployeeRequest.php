<?php

namespace App\Http\Requests;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('employees.create') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'name' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'hired_at' => ['required', 'date'],
            'vacation_days_per_year' => ['required', 'integer', 'min:1', 'max:60'],
            'status' => ['required', new Enum(EmployeeStatus::class)],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        $data = $this->validated();
        $data['vacation_balance_days'] = $data['vacation_days_per_year'];

        return $data;
    }
}
