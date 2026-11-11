<x-app-layout>
    <div class="container py-4">
        <a href="{{ session('pse_users_return_url', route('pse.jovens.index')) }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para a Lista
        </a>

        {{-- Alerta de sucesso para feedback da ação --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h2 mb-0">Perfil do Jovem: {{ $jovem->user->name }}</h1>
            <div class="d-flex align-items-center gap-3">
                @if ($jovem->user->isActive())
                    <span class="badge bg-success fs-6">Status: Ativo</span>
                @else
                    <span class="badge bg-danger fs-6">Status: Bloqueado</span>
                @endif
                <form action="{{ route('pse.users.toggle-status', $jovem->user->id) }}" method="POST">
                    @csrf
                    @if ($jovem->user->isActive())
                        <button type="submit" class="btn btn-sm btn-warning" title="Bloquear acesso do usuário">
                            <i class="bi bi-lock-fill me-1"></i>Bloquear
                        </button>
                    @else
                        <button type="submit" class="btn btn-sm btn-success" title="Ativar acesso do usuário">
                            <i class="bi bi-unlock-fill me-1"></i>Ativar
                        </button>
                    @endif
                </form>
            </div>
        </div>
        <hr class="my-4">

        <div class="card shadow-sm p-4 mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="fw-bold">Informações Pessoais</h5>
                    <p><strong>Nome:</strong> {{ $jovem->user->name }}</p>
                    <p><strong>CPF:</strong> {{ $jovem->cpf_formatado ?? 'Não informado' }}</p>
                    <p><strong>E-mail:</strong> {{ $jovem->user->email }}</p>
                    <p><strong>Telefone:</strong> {{ $jovem->telefone ?? 'Não informado' }}</p>
                    <p><strong>Data de Nasc.:</strong> {{ $jovem->data_nascimento ? \Carbon\Carbon::parse($jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                    <p><strong>Gênero:</strong> {{ $jovem->genero ?? 'Não informado' }}</p>
                    <p><strong>Endereço:</strong> {{ $jovem->endereco ?? 'Não informado' }}</p>
                    <p><strong>Cidade/Estado:</strong> {{ $jovem->cidade ?? 'Não informado' }}/{{ $jovem->estado ?? 'Não informado' }}</p>
                    <p><strong>Deficiência:</strong> {{ $jovem->deficiencia ?? 'Não informado' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="fw-bold">Informações Profissionais</h5>
                    <p><strong>Formação Acadêmica:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->formacao_academica ?? 'Não informado' }}</p>
                    <p><strong>Experiência Profissional:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->experiencia_profissional ?? 'Não informado' }}</p>
                    <p><strong>Habilidades:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->habilidades ?? 'Não informado' }}</p>
                    @if ($jovem->link_portfolio)
                        <p><strong>Portfólio:</strong> <a href="{{ $jovem->link_portfolio }}" target="_blank" class="text-primary">Ver Portfólio</a></p>
                    @endif
                    @if ($jovem->link_linkedin)
                        <p><strong>LinkedIn:</strong> <a href="{{ $jovem->link_linkedin }}" target="_blank" class="text-primary">Ver LinkedIn</a></p>
                    @endif
                    <p class="mt-3"><strong>Currículo PDF:</strong>
                        @if ($jovem->curriculo_path)
                            <a href="{{ Storage::url($jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white">Visualizar Currículo</a>
                        @else
                            Não enviado
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
