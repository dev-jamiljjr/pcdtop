<aside class="d-flex flex-column p-3 vh-100 position-fixed text-center" style="width: 102px; background-color: var(--pcdtop-dark-blue); color: #fff;">
    {{-- Logo do Projeto --}}
    <a href="{{ route('home') }}" class="d-block pt-3 mb-3">
        <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="max-height: 25px;">
    </a>
    <hr>
    {{-- Itens de Navegação --}}
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Link Início --}}
        <li class="nav-item">
            <a href="{{ route('home') }}"
               class="nav-link d-flex flex-column align-items-center py-3 px-2 {{ request()->routeIs('home') ? 'active' : 'text-white' }}"
               aria-current="page"
               style="{{ request()->routeIs('home') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                <i class="bi bi-house-door-fill fs-4 mb-1"></i>
                <span style="font-size: 0.75rem;">Início</span>
            </a>
        </li>
        {{-- Link Jovem --}}
        <li class="nav-item">
            <a href="{{ route('jovem.index') }}"
               class="nav-link d-flex flex-column align-items-center py-3 px-2 {{ request()->routeIs('jovem.index') ? 'active' : 'text-white' }}"
               style="{{ request()->routeIs('jovem.index') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                <i class="bi bi-person-fill fs-4 mb-1"></i>
                <span style="font-size: 0.75rem;">Jovem</span>
            </a>
        </li>
        {{-- Link Empresa --}}
        <li class="nav-item">
            <a href="{{ route('empresa.index') }}"
               class="nav-link d-flex flex-column align-items-center py-3 px-2 {{ request()->routeIs('empresa.index') ? 'active' : 'text-white' }}"
               style="{{ request()->routeIs('empresa.index') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                <i class="bi bi-building-fill fs-4 mb-1"></i>
                <span style="font-size: 0.75rem;">Empresa</span>
            </a>
        </li>
        {{-- Link PSE --}}
        <li class="nav-item">
            <a href="{{ route('pse.index') }}"
               class="nav-link d-flex flex-column align-items-center py-3 px-2 {{ request()->routeIs('pse.index') ? 'active' : 'text-white' }}"
               style="{{ request()->routeIs('pse.index') ? 'background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue);' : '' }} border-radius: 0.375rem;">
                <i class="bi bi-briefcase-fill fs-4 mb-1"></i>
                <span style="font-size: 0.75rem;">PSE</span>
            </a>
        </li>
    </ul>
    <hr>
    {{-- Menu do Usuário Compactado --}}
    <div class="dropdown pb-3">
        {{-- O link principal (a) é o gatilho do dropdown e contém o avatar e o strong empilhados --}}
        <a href="#" class="d-flex flex-column align-items-center text-decoration-none link-light" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Avatar do usuário" width="32" height="32" class="rounded-circle">
            {{-- O strong tag agora é o dropdown-toggle, alinhando seu conteúdo horizontalmente --}}
            <strong class="d-inline-flex align-items-center dropdown-toggle mt-1" style="font-size: 0.7rem; white-space: nowrap;">
                Jamil J. Jr.
            </strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><h6 class="dropdown-header">Jamil J. Jr.</h6></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Meu Perfil</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Configurações</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
        </ul>
    </div>
</aside>
