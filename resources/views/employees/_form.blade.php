@php
    $selectedStatus = old('status', $employee->status?->value ?? \App\Enums\EmployeeStatus::Active->value);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nome <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text" value="{{ old('name', $employee->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="job_title">Cargo <span class="text-danger">*</span></label>
            @php($selectedJobTitle = old('job_title', $employee->job_title))
            <select id="job_title" name="job_title" class="form-control @error('job_title') is-invalid @enderror" required>
                <option value="">Selecione</option>
                @foreach ($jobTitles as $jobTitle)
                    <option value="{{ $jobTitle }}" @selected($selectedJobTitle === $jobTitle)>{{ $jobTitle }}</option>
                @endforeach
                @if ($selectedJobTitle && ! in_array($selectedJobTitle, $jobTitles, true))
                    <option value="{{ $selectedJobTitle }}" selected>{{ $selectedJobTitle }}</option>
                @endif
            </select>
            @error('job_title')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="department_id">Departamento <span class="text-danger">*</span></label>
            <select id="department_id" name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                <option value="">Selecione</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected((int) old('department_id', $employee->department_id) === $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>
            @error('department_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="hired_at">Admissão <span class="text-danger">*</span></label>
            <input id="hired_at" name="hired_at" type="date" value="{{ old('hired_at', optional($employee->hired_at)->format('Y-m-d')) }}" class="form-control @error('hired_at') is-invalid @enderror" required>
            @error('hired_at')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="vacation_days_per_year">Dias de férias/ano <span class="text-danger">*</span></label>
            <input id="vacation_days_per_year" name="vacation_days_per_year" type="number" min="1" max="60" value="{{ old('vacation_days_per_year', $employee->vacation_days_per_year ?: 30) }}" class="form-control @error('vacation_days_per_year') is-invalid @enderror" required>
            @error('vacation_days_per_year')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="status">Status <span class="text-danger">*</span></label>
    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
        @foreach ($statuses as $status)
            <option value="{{ $status->value }}" @selected($selectedStatus === $status->value)>{{ ucfirst($status->value) }}</option>
        @endforeach
    </select>
    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
</div>
