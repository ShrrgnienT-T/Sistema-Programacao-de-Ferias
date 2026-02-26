<section>
   <header class="mb-4">
      <h2 class="card-title">Informações do Perfil</h2>
      <p class="card-subtitle">Atualize as informações da sua conta e endereço de e-mail.</p>
   </header>

   <form id="send-verification" method="post" action="{{ route('verification.send') }}">
      @csrf
   </form>

   <form method="post" action="{{ route('profile.update') }}">
      @csrf
      @method('patch')

      <div class="form-group">
         <label for="name">Nome <span class="text-danger">*</span></label>
         <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
         @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror
      </div>

      <div class="form-group">
         <label for="email">E-mail <span class="text-danger">*</span></label>
         <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
         @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
         @enderror

         @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
               <p class="text-warning small">
                  Seu e-mail não foi verificado.
                  <button form="send-verification" class="btn btn-link btn-sm p-0">
                     Clique aqui para reenviar o e-mail de verificação.
                  </button>
               </p>

               @if (session('status') === 'verification-link-sent')
                  <p class="text-success small mt-2">
                     Um novo link de verificação foi enviado para seu e-mail.
                  </p>
               @endif
            </div>
         @endif
      </div>

      <div class="d-flex align-items-center gap-3 mt-4">
         <button type="submit" class="btn btn-primary">Salvar</button>

         @if (session('status') === 'profile-updated')
            <span class="text-success small">Salvo com sucesso!</span>
         @endif
      </div>
   </form>
</section>
