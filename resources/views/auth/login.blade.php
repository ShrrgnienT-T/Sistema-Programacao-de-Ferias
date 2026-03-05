<x-guest-layout>
   <div
      class="min-h-screen w-full flex flex-col justify-center items-center bg-[conic-gradient(at_50%_50%,#f8f6f2_0deg,#e7d7c2_90deg,#f3ede4_180deg,#e7d7c2_270deg,#f8f6f2_360deg)] bg-repeat bg-fixed"
      style="background-size: 800px 800px;">
      <div class="w-full max-w-md mx-auto">
         <div class="flex flex-col items-center mb-8">
            <img src="/morhena.png" alt="Logo Grupo Morhena" class="h-20 w-auto rounded-xl shadow-lg mb-2">
            <h1 class="text-2xl font-bold text-[#391800] tracking-tight mt-2">Bem-vindo ao Sistema de Férias</h1>
            <p class="text-[#7c5e3b] text-base text-center mt-1">Acesse sua conta para continuar</p>
         </div>
         <div class="bg-white/90 rounded-2xl shadow-2xl p-8">
            @if (session('status'))
               <div class="mb-4 font-medium text-sm text-green-600">
                  {{ session('status') }}
               </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
               @csrf
               <div>
                  <label for="email" class="block text-sm font-medium text-[#7c5e3b]">E-mail</label>
                  <input id="email" name="email" type="email" autocomplete="username" required autofocus
                     value="{{ old('email') }}"
                     class="mt-1 block w-full rounded-lg border border-[#e7d7c2] bg-[#f8f6f2] px-4 py-2 text-[#391800] focus:border-[#F0ACB8] focus:ring-2 focus:ring-[#F0ACB8] transition" />
                  @if ($errors->has('email'))
                     <span
                        class="text-red-600 text-xs mt-1">{{ $errors->first('email', 'E-mail inválido ou obrigatório.') }}</span>
                  @endif
               </div>
               <div>
                  <label for="password" class="block text-sm font-medium text-[#7c5e3b]">Senha</label>
                  <input id="password" name="password" type="password" autocomplete="current-password" required
                     class="mt-1 block w-full rounded-lg border border-[#e7d7c2] bg-[#f8f6f2] px-4 py-2 text-[#391800] focus:border-[#F0ACB8] focus:ring-2 focus:ring-[#F0ACB8] transition" />
                  @if ($errors->has('password'))
                     <span
                        class="text-red-600 text-xs mt-1">{{ $errors->first('password', 'Senha obrigatória.') }}</span>
                  @endif
               </div>
               <div class="flex items-center justify-between">
                  <label class="flex items-center text-[#7c5e3b]">
                     <input id="remember_me" name="remember" type="checkbox"
                        class="rounded border-[#e7d7c2] text-[#FF750F] shadow-sm focus:ring-[#F0ACB8]">
                     <span class="ml-2 text-sm">Lembrar-me</span>
                  </label>
                  @if (Route::has('password.request'))
                     <a href="{{ route('password.request') }}"
                        class="text-sm text-[#FF750F] hover:underline font-medium">Esqueceu sua senha?</a>
                  @endif
               </div>
               <button type="submit"
                  class="w-full py-3 px-6 bg-gradient-to-r from-[#F0ACB8] to-[#FF750F] text-white font-bold rounded-lg shadow-lg hover:from-[#FF750F] hover:to-[#F0ACB8] transition-all text-lg mt-2">Entrar</button>
            </form>
         </div>
         <div class="mt-8 text-center text-xs text-[#7c5e3b] opacity-70">&copy; {{ date('Y') }} Grupo Morhena. Todos
            os
            direitos reservados.</div>
      </div>
</x-guest-layout>
