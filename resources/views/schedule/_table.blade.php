<table class="table table-bordered">
   <thead>
      <tr>
         <th>Colaborador</th>
         @for ($d = 1; $d <= \Carbon\Carbon::create($year, $month, 1)->daysInMonth; $d++)
            <th>{{ $d }}</th>
         @endfor
      </tr>
   </thead>
   <tbody>
      @foreach ($employees as $employee)
         <tr>
            <td>{{ $employee->name }}</td>
            @for ($d = 1; $d <= \Carbon\Carbon::create($year, $month, 1)->daysInMonth; $d++)
               @php
                  $schedule = $employee->schedules->firstWhere('day', $d);
               @endphp
               <td>
                  @if ($schedule)
                     <span title="{{ $schedule->obs }}">{{ $schedule->status }}</span>
                  @endif
               </td>
            @endfor
         </tr>
      @endforeach
   </tbody>
</table>
