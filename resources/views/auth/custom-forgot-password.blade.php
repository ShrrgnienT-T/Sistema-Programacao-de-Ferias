@extends('layouts.base')

@section('content')
   <div class="auth-wrapper">
      <div class="auth-card">
         <h1 class="auth-title">Redefinir Senha</h1>
         <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
               <label for="email">E-mail</label>
               <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                  class="input">
            </div>
            <button type="submit" class="btn btn-primary w-full mt-4">Enviar link de redefinição</button>
         </form>
         <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="link">Voltar para login</a>
         </div>
      </div>
   </div>
@endsection

@push('styles')
   <style>
      .auth-wrapper {
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
         background: var(--bg-gradient);
      }

      .auth-card {
         background: var(--bg2);
         border-radius: 16px;
         box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
         padding: 2.5rem 2rem;
         width: 100%;
         max-width: 400px;
      }

      .auth-title {
         font-size: 1.5rem;
         font-weight: 600;
         margin-bottom: 1.5rem;
         color: var(--text);
         text-align: center;
      }

      .input {
         width: 100%;
         padding: 10px 12px;
         border-radius: 8px;
         border: 1px solid var(--border2);
         background: var(--bg2);
         color: var(--text);
         font-size: 15px;
         margin-bottom: 1rem;
         outline: none;
         transition: border .2s;
      }

      .input:focus {
         border-color: var(--anali-c);
      }

      .btn-primary {
         background: var(--accent);
         color: #fff;
         border: none;
         border-radius: 8px;
         padding: 10px 0;
         font-size: 1rem;
         font-weight: 500;
         cursor: pointer;
         transition: background .2s;
      }

      .btn-primary:hover {
         background: var(--accent-dark);
      }

      .link {
         color: var(--anali-c);
         text-decoration: underline;
         font-size: 0.95rem;
      }
   </style>
@endpush
