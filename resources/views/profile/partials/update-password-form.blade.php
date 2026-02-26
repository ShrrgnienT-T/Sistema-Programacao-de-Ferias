<section>
   <header class="mb-4">
      <h2 class="card-title">Alterar Senha</h2>
      <p class="card-subtitle">Use uma senha longa e aleatória para manter sua conta segura.</p>
   </header>

   <form method="post" action="{{ route('password.update') }}">
      @csrf
      @method('put')

      <div class="form-group">
         <label for="update_password_current_password">Senha Atual <span class="text-danger">*</span></label>
         <input id="update_password_current_password" name="current_password" type="password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password">
         @error('current_password', 'updatePassword')
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror
      </div>

      <div class="form-group">
         <label for="update_password_password">Nova Senha <span class="text-danger">*</span></label>
         <input id="update_password_password" name="password" type="password"
            class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
         @error('password', 'updatePassword')
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror
      </div>

      <div class="form-group">
         <label for="update_password_password_confirmation">Confirmar Nova Senha <span
               class="text-danger">*</span></label>
         <input id="update_password_password_confirmation" name="password_confirmation" type="password"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password">
         @error('password_confirmation', 'updatePassword')
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror
      </div>

      <div class="d-flex align-items-center gap-3 mt-4">
         <button type="submit" class="btn btn-primary">Salvar</button>

         @if (session('status') === 'password-updated')
            <span class="text-success small">Senha atualizada!</span>
         @endif
      </div>
   </form>
</section>
