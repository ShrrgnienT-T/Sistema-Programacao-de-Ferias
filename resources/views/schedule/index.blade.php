@extends('layouts.app')

@section('content')
   <div class="container">
      <h1>Escala de Trabalho</h1>
      <form method="GET" action="{{ route('escala.index') }}" class="mb-3">
         <div class="row g-2 align-items-end">
            <div class="col-auto">
               <label for="year" class="form-label">Ano</label>
               <input type="number" name="year" id="year" class="form-control" value="{{ $year }}">
            </div>
            <div class="col-auto">
               <label for="month" class="form-label">Mês</label>
               <input type="number" name="month" id="month" class="form-control" value="{{ $month }}"
                  min="1" max="12">
            </div>
            <div class="col-auto">
               <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
         </div>
      </form>
      @include('schedule._table', ['employees' => $employees, 'year' => $year, 'month' => $month])
   </div>
@endsection
