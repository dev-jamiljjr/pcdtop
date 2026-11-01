<x-app-layout>
    <div class="container py-4">

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="h2 mb-4">Meu Perfil</h1>

        <p class="mb-1">Bem-vindo(a), <strong class="text-primary">{{ Auth::user()->name }}</strong>!</p>
        <p class="mb-1">Seu e-mail: <strong class="text-primary">{{ Auth::user()->email }}</strong></p>
        <p>Seu tipo de perfil: <strong class="text-primary">{{ Auth::user()->tipo_perfil }}</strong>.</p>
        <hr class="my-4">

        @if (Auth::user()->tipo_perfil === 'jovem' && Auth::user()->jovem)
            <h2 class="h4 mb-3">Detalhes do Perfil Jovem</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Dados Pessoais</h5>
                        <p><strong>CPF:</strong> {{ Auth::user()->jovem->cpf ?? 'Não informado' }}</p>
                        <p><strong>Data de Nascimento:</strong> {{ Auth::user()->jovem->data_nascimento ? \Carbon\Carbon::parse(Auth::user()->jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                        <p><strong>Telefone:</strong> {{ Auth::user()->jovem->telefone ?? 'Não informado' }}</p>
                        <p><strong>Gênero:</strong> {{ Auth::user()->jovem->genero ?? 'Não informado' }}</p>
                        <p><strong>Deficiência:</strong> {{ Auth::user()->jovem->deficiencia ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Endereço</h5>
                        <p><strong>Endereço:</strong> {{ Auth::user()->jovem->endereco ?? 'Não informado' }}</p>
                        <p><strong>Bairro:</strong> {{ Auth::user()->jovem->bairro ?? 'Não informado' }}</p>
                        <p><strong>Cidade/Estado:</strong> {{ (Auth::user()->jovem->cidade && Auth::user()->jovem->estado) ? Auth::user()->jovem->cidade . '/' . Auth::user()->jovem->estado : 'Não informado' }}</p>
                        <p><strong>CEP:</strong> {{ Auth::user()->jovem->cep ?? 'Não informado' }}</p>
                    </div>
                </div>
                <hr class="my-3">
                <div class="row">
                    <h5 class="h6 text-muted mb-2">Qualificação Profissional</h5>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Formação:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->formacao_academica ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Experiência Profissional:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->experiencia_profissional ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Habilidades:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->habilidades ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        @if (Auth::user()->jovem->link_portfolio)
                            <p><strong>Portfólio:</strong> <a href="{{ Auth::user()->jovem->link_portfolio }}" target="_blank" class="text-primary"><i class="bi bi-link-45deg me-1"></i>Ver Portfólio</a></p>
                        @else
                            <p><strong>Portfólio:</strong> Não informado</p>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        @if (Auth::user()->jovem->link_linkedin)
                            <p><strong>LinkedIn:</strong> <a href="{{ Auth::user()->jovem->link_linkedin }}" target="_blank" class="text-primary"><i class="bi bi-linkedin me-1"></i>Ver LinkedIn</a></p>
                        @else
                            <p><strong>LinkedIn:</strong> Não informado</p>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <p><strong>Currículo PDF:</strong>
                        @if (Auth::user()->jovem->curriculo_path) {{-- <<< CORREÇÃO AQUI --}}
                            <a href="{{ Storage::url(Auth::user()->jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="bi bi-file-earmark-pdf me-1"></i>Visualizar Currículo</a>
                        @else
                            <span class="text-muted">Não enviado</span>
                        @endif
                    </p>
                </div>
            </div>
        @elseif (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->empresa)
            <h2 class="h4 mb-3">Detalhes do Perfil Empresa</h2>
            <div class="card shadow-sm p-4 mb-3">
                {{-- Código da Empresa --}}
            </div>
        @endif

        <div class="mt-4">
            @if (Auth::user()->tipo_perfil === 'jovem')
                <a href="{{ route('jovem.curriculo.step1') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);"><i class="bi bi-pencil-square me-2"></i>Editar Perfil / Currículo</a>
            @else
                <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);"><i class="bi bi-pencil-square me-2"></i>Editar Cadastro</a>
            @endif
        </div>
    </div>
</x-app-layout>
