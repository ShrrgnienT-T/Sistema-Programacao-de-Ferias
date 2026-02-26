<header>
   <div class="logo">
      <div class="logo-icon">🏥</div>
      <div class="logo-text">
         <strong>Controle de Férias — Morhena 2026</strong>
         <span>Grupo Morhena · Hospitalar · Gestão de Pessoas</span>
      </div>
   </div>

   <nav>
      <a href="{{ route('dashboard') }}" class="nav-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}">📊
         Dashboard</a>

      @can('employees.view')
         <a href="{{ route('employees.index') }}" class="nav-btn {{ request()->routeIs('employees.*') ? 'active' : '' }}">👤
            Cadastro</a>
      @endcan

      <a href="{{ route('profile.edit') }}" class="nav-btn {{ request()->routeIs('profile.*') ? 'active' : '' }}">⚙️
         Perfil</a>
   </nav>

   <div class="header-right">
      <button type="button" class="theme-toggle" id="theme-toggle" title="Alternar tema">
         <span class="theme-icon-dark">🌙</span>
         <span class="theme-icon-light">☀️</span>
      </button>
      <div class="date-chip" id="date-chip"></div>
      <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button type="submit" class="btn btn-danger btn-sm">Sair</button>
      </form>
   </div>
</header>
