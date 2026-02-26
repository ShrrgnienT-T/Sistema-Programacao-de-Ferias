<?php

namespace App\Http\Requests;

use App\Enums\EmployeeJobTitle;
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
            'job_title' => ['required', new Enum(EmployeeJobTitle::class)],
            'hired_at' => ['required', 'date'],
            'vacation_days_per_year' => ['required', 'integer', 'min:1', 'max:60'],
            'status' => ['required', new Enum(EmployeeStatus::class)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'department_id.required' => 'O departamento é obrigatório.',
            'department_id.exists' => 'O departamento selecionado não existe.',
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'job_title.required' => 'O cargo é obrigatório.',
            'job_title.Illuminate\Validation\Rules\Enum' => 'O cargo selecionado é inválido.',
            'hired_at.required' => 'A data de admissão é obrigatória.',
            'hired_at.date' => 'A data de admissão deve ser uma data válida.',
            'vacation_days_per_year.required' => 'A quantidade de dias de férias é obrigatória.',
            'vacation_days_per_year.integer' => 'A quantidade de dias deve ser um número inteiro.',
            'vacation_days_per_year.min' => 'A quantidade de dias deve ser no mínimo 1.',
            'vacation_days_per_year.max' => 'A quantidade de dias deve ser no máximo 60.',
            'status.required' => 'O status é obrigatório.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'department_id' => 'departamento',
            'name' => 'nome',
            'job_title' => 'cargo',
            'hired_at' => 'data de admissão',
            'vacation_days_per_year' => 'dias de férias por ano',
            'status' => 'status',
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
