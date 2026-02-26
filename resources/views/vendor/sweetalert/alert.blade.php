@if (config('sweetalert.animation.enable'))
   <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
@endif

@if (config('sweetalert.theme') != 'default')
   <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
@endif

@if (config('sweetalert.neverLoadJS') === false)
   <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endif

<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Handle session-based alerts (toast/alert)
      @if (Session::has('alert.config'))
         Swal.fire({!! Session::pull('alert.config') !!});
      @endif

      // Handle confirm delete buttons
      document.addEventListener('click', function(event) {
         var target = event.target;
         var confirmDeleteElement = target.closest('[data-confirm-delete]');

         if (confirmDeleteElement) {
            event.preventDefault();

            var route = confirmDeleteElement.dataset.route || confirmDeleteElement.href;
            var title = confirmDeleteElement.dataset.title ||
               '{{ config('sweetalert.confirm_delete_title', 'Tem certeza?') }}';
            var text = confirmDeleteElement.dataset.text ||
               '{{ config('sweetalert.confirm_delete_text', 'Esta ação não poderá ser desfeita!') }}';

            Swal.fire({
               title: title,
               text: text,
               icon: '{{ config('sweetalert.confirm_delete_icon', 'warning') }}',
               showCancelButton: {{ config('sweetalert.confirm_delete_show_cancel_button', true) ? 'true' : 'false' }},
               confirmButtonColor: '{{ config('sweetalert.confirm_delete_confirm_button_color', '#d33') }}',
               cancelButtonColor: '{{ config('sweetalert.confirm_delete_cancel_button_color', '#6c757d') }}',
               confirmButtonText: '{{ config('sweetalert.confirm_delete_confirm_button_text', 'Sim, excluir!') }}',
               cancelButtonText: '{{ config('sweetalert.confirm_delete_cancel_button_text', 'Cancelar') }}',
               showLoaderOnConfirm: {{ config('sweetalert.confirm_delete_show_loader_on_confirm', true) ? 'true' : 'false' }},
               reverseButtons: true
            }).then(function(result) {
               if (result.isConfirmed) {
                  var form = document.createElement('form');
                  form.action = route;
                  form.method = 'POST';
                  form.innerHTML = '@csrf @method('DELETE')';
                  document.body.appendChild(form);
                  form.submit();
               }
            });
         }
      });
   });
</script>
