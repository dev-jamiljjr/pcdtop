<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Painel
        </a>

        <h1 class="h2 mb-4">Empresas Cadastradas (PSE)</h1>
        <hr class="my-4">
        
        {{-- Alerta de sucesso para feedback da ação --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($empresas->isEmpty())
            <div class="alert alert-info">Nenhuma empresa cadastrada ainda.</div>
        @else
            <div class="list-group">
                @foreach ($empresas as $empresaUser)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 fw-bold">{{ $empresaUser->empresa->nome_fantasia ?? $empresaUser->name }}</h5>
                             {{-- <<< ALTERAÇÃO: BADGE DE STATUS >>> --}}
                             @if ($empresaUser->isActive())
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-danger">Bloqueada</span>
                            @endif
                        </div>
                        <p class="mb-1"><strong>E-mail:</strong> {{ $empresaUser->email }}</p>
                        @if ($empresaUser->empresa)
                            {{-- CORREÇÃO AQUI: Utiliza o accessor cnpj_formatado para exibir a máscara --}}
                            <p class="mb-1"><strong>CNPJ:</strong> {{ $empresaUser->empresa->cnpj_formatado ?? $empresaUser->empresa->cnpj ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Cidade/Estado:</strong> {{ $empresaUser->empresa->cidade ?? 'N/A' }}/{{ $empresaUser->empresa->estado ?? 'N/A' }}</p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('pse.empresas.show', $empresaUser->empresa->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill me-1"></i>Ver Detalhes
                                </a>
                                {{-- <<< ALTERAÇÃO: FORMULÁRIO DE AÇÃO DE STATUS >>> --}}
                                <form action="{{ route('pse.users.toggle-status', $empresaUser->id) }}" method="POST">
                                    @csrf
                                    @if ($empresaUser->isActive())
                                        <button type="submit" class="btn btn-sm btn-warning" title="Bloquear acesso da empresa">
                                            <i class="bi bi-lock-fill me-1"></i>Bloquear
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-success" title="Ativar acesso da empresa">
                                            <i class="bi bi-unlock-fill me-1"></i>Ativar
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @else
                            <p class="text-danger mt-2">Detalhes do perfil empresa não disponíveis.</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $empresas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
