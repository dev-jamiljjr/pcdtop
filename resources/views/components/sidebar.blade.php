<aside class="d-flex flex-column p-3 vh-100 position-fixed text-center" style="width: 107px; background-color: var(--pcdtop-dark-blue); color: #fff;">
    {{-- Logo do Projeto --}}
    <a href="{{ route('home') }}" class="d-block mb-3">
        <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="max-height: 25px;">
    </a>
    <hr>
    {{-- Itens de Navegação --}}
    <ul class="nav nav-pills flex-column mb-auto">

        @guest
            {{-- LINKS PARA VISITANTES (NÃO LOGADOS) --}}
            <li class="nav-item">
                <a href="{{ route('home') }}"
                   class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('home') ? 'active' : 'text-white' }}"
                   style="{{ request()->routeIs('home') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                    <i class="bi bi-house-door-fill fs-4 mb-1"></i>
                    <span style="font-size: 0.75rem;">Início</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('login') }}"
                   class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('login') ? 'active' : 'text-white' }}"
                   style="{{ request()->routeIs('login') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                    <i class="bi bi-box-arrow-in-right fs-4 mb-1"></i>
                    <span style="font-size: 0.75rem;">Login</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}"
                   class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('register') ? 'active' : 'text-white' }}"
                   style="{{ request()->routeIs('register') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                    <i class="bi bi-person-plus fs-4 mb-1"></i>
                    <span style="font-size: 0.75rem;">Registro</span>
                </a>
            </li>
             {{-- NOVO LINK "ACESSO ADMIN" PARA VISITANTES --}}
            <li class="nav-item">
                <a href="{{ route('pse.show-admin-activation-form') }}"
                   class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('pse.show-admin-activation-form') ? 'active' : 'text-white' }}"
                   style="{{ request()->routeIs('pse.show-admin-activation-form') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                    <i class="bi bi-shield-lock fs-4 mb-1"></i>
                    <span style="font-size: 0.75rem;">Acesso Admin</span>
                </a>
            </li>
        @endguest

        @auth
            {{-- Links para usuários logados --}}
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('home') ? 'active' : 'text-white' }}">
                    <i class="bi bi-speedometer2 fs-4 mb-1"></i><span style="font-size: 0.75rem;">Painel</span>
                </a>
            </li>
            @if (Auth::user()->tipo_perfil === 'empresa')
                <li class="nav-item">
                    <a href="{{ route('vagas.index') }}" class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('vagas.*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-card-list fs-4 mb-1"></i><span style="font-size: 0.75rem;">Minhas Vagas</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->tipo_perfil === 'jovem')
                <li class="nav-item">
                    <a href="{{ route('vagas.search') }}" class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('vagas.search') ? 'active' : 'text-white' }}">
                        <i class="bi bi-search fs-4 mb-1"></i><span style="font-size: 0.75rem;">Buscar Vagas</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->tipo_perfil === 'pse')
                <li class="nav-item">
                    <a href="{{ route('pse.dashboard') }}" class="nav-link d-flex flex-column align-items-center py-3 {{ request()->routeIs('pse.*') ? 'active' : 'text-white' }}">
                        <i class="bi bi-person-workspace fs-4 mb-1"></i><span style="font-size: 0.75rem;">Painel PSE</span>
                    </a>
                </li>
            @endif
        @endauth

    </ul>
    <hr>
    {{-- Menu do Usuário Compactado --}}
    @auth
        <div class="dropdown">
            <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Avatar do usuário" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><h6 class="dropdown-header">{{ Auth::user()->name ?? 'Usuário' }}</h6></li>
                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person-circle me-2"></i>Meu Perfil</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Configurações</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout.temp') }}">
                        <i class="bi bi-box-arrow-right me-2"></i>Sair
                    </a>
                </li>
            </ul>
        </div>
    @endauth
</aside>
