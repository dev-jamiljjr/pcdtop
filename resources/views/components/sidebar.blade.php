{{--
|--------------------------------------------------------------------------
| Componente: Sidebar
|--------------------------------------------------------------------------
|
| Menu de navegação lateral principal, fixo no desktop.
| Baseado no documento de layout do PCD TOP.
|
--}}
<aside class="d-flex flex-column p-3 vh-100 position-fixed" style="width: 280px; background-color: var(--pcdtop-dark-blue); color: #fff;">
    {{-- Logo do Projeto --}}
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        {{-- Substitua 'logo-pcdtop-branca.png' pelo nome real do seu arquivo de logo --}}
        <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="max-height: 83px;">
    </a>
    <hr>
    {{-- Itens de Navegação --}}
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            {{-- O item ativo terá a classe 'active' e o estilo customizado --}}
            <a href="#" class="nav-link active d-flex align-items-center" aria-current="page" style="background-color: var(--pcdtop-yellow); color: var(--pcdtop-dark-blue); border-radius: 0.375rem;">
                <i class="bi bi-house-door-fill me-3 fs-5"></i>
                <span class="fs-6 fw-bold">Início</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-person-fill me-3 fs-5"></i>
                <span class="fs-6">Jovem</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-building-fill me-3 fs-5"></i>
                <span class="fs-6">Empresa</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-briefcase-fill me-3 fs-5"></i>
                <span class="fs-6">PSE</span>
            </a>
        </li>
    </ul>
    <hr>
    {{-- Menu do Usuário --}}
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://via.placeholder.com/32" alt="Avatar do usuário" width="32" height="32" class="rounded-circle me-2">
            <strong>Jamil J. Jr.</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Meu Perfil</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Configurações</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
        </ul>
    </div>
</aside>
