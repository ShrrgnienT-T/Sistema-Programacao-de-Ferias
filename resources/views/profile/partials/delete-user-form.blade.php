<section>
   <header class="mb-4">
      <h2 class="card-title text-danger">Excluir Conta</h2>
      <p class="card-subtitle">Após a exclusão, todos os seus dados serão permanentemente removidos. Antes de excluir,
         faça backup de qualquer informação que deseja manter.</p>
   </header>

   <button type="button" class="btn btn-danger"
      onclick="document.getElementById('modal-delete-account').classList.add('open')">
      Excluir Conta
   </button>

   <div class="modal-bg" id="modal-delete-account">
      <div class="modal">
         <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="modal-title text-danger">Confirmar Exclusão de Conta</div>
            <div class="modal-sub">Esta ação não pode ser desfeita</div>

            <p class="mb-3" style="color: var(--text); font-size: 13px;">
               Tem certeza que deseja excluir sua conta? Todos os seus dados serão permanentemente removidos.
            </p>

            <div class="form-group">
               <label for="delete_password">Senha <span class="text-danger">*</span></label>
               <input id="delete_password" name="password" type="password"
                  class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                  placeholder="Digite sua senha para confirmar">
               @error('password', 'userDeletion')
                  <span class="invalid-feedback">{{ $message }}</span>
               @enderror
            </div>

            <div class="d-flex gap-2 mt-4" style="justify-content: flex-end;">
               <button type="button" class="btn btn-secondary"
                  onclick="document.getElementById('modal-delete-account').classList.remove('open')">Cancelar</button>
               <button type="submit" class="btn btn-danger">Excluir Conta</button>
            </div>
         </form>
      </div>
   </div>
</section>

@if ($errors->userDeletion->isNotEmpty())
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         document.getElementById('modal-delete-account').classList.add('open');
      });
   </script>
@endif
