<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Painel
        </a>

        <h1 class="h2 mb-4">Jovens Cadastrados (PSE)</h1>
        <hr class="my-4">

        {{-- Alerta de sucesso para feedback da ação --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($jovens->isEmpty())
            <div class="alert alert-info">Nenhum jovem cadastrado ainda.</div>
        @else
            <div class="list-group">
                @foreach ($jovens as $jovemUser)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 fw-bold">{{ $jovemUser->name }}</h5>
                            {{-- <<< ALTERAÇÃO: BADGE DE STATUS >>> --}}
                            @if ($jovemUser->isActive())
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-danger">Bloqueado</span>
                            @endif
                        </div>
                        <p class="mb-1"><strong>E-mail:</strong> {{ $jovemUser->email }}</p>
                        @if ($jovemUser->jovem)
                            <p class="mb-1"><strong>Telefone:</strong> {{ $jovemUser->jovem->telefone ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Cidade/Estado:</strong> {{ $jovemUser->jovem->cidade ?? 'N/A' }}/{{ $jovemUser->jovem->estado ?? 'N/A' }}</p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('pse.jovens.show', ['jovem' => $jovemUser->jovem->id, 'return_to_route' => 'pse.jovens.index']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-person-lines-fill me-1"></i>Ver Perfil Completo
                                </a>
                                {{-- <<< ALTERAÇÃO: FORMULÁRIO DE AÇÃO DE STATUS >>> --}}
                                <form action="{{ route('pse.users.toggle-status', $jovemUser->id) }}" method="POST">
                                    @csrf
                                    @if ($jovemUser->isActive())
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
                        @else
                            <p class="text-danger mt-2">Detalhes do perfil jovem não disponíveis (perfil não preenchido).</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $jovens->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
