{{--
|--------------------------------------------------------------------------
| Componente: Header
|--------------------------------------------------------------------------
|
| Cabeçalho principal do sistema.
| Conterá o logo, e será a base para o botão hamburger (mobile) e avatar do usuário.
|
--}}
<header class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--pcdtop-dark-blue);">
    <div class="container-fluid">
        {{-- Logo do Projeto --}}
        <a class="navbar-brand me-auto" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="max-height: 50px;">
        </a>

        {{-- Botão Hamburger (visível apenas em mobile/sidebar colapsada) --}}
        {{-- Será implementado na próxima etapa para controlar o offcanvas --}}
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Avatar do Usuário no canto superior direito --}}
        <div class="d-none d-lg-block ms-auto"> {{-- Escondido em mobile, visível em desktop --}}
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Avatar do usuário" width="32" height="32" class="rounded-circle me-2">
                    <strong>Jamil J. Jr.</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Meu Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Configurações</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
