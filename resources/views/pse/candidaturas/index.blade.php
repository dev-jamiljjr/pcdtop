<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Painel
        </a>

        <h1 class="h2 mb-4">Todas as Candidaturas (PSE)</h1>
        <hr class="my-4">

        @if ($candidaturas->isEmpty())
            <div class="alert alert-info">Nenhuma candidatura registrada no sistema ainda.</div>
        @else
            <div class="list-group">
                @foreach ($candidaturas as $candidatura)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 fw-bold">
                                {{ $candidatura->jovem->user->name ?? 'Jovem Desconhecido' }}
                                <small class="text-muted"> candidata-se para </small>
                                {{ $candidatura->vaga->titulo ?? 'Vaga Desconhecida' }}
                            </h5>
                            <small class="text-muted">Em: {{ $candidatura->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-1"><strong>Empresa:</strong> {{ $candidatura->vaga->empresa->nome_fantasia ?? 'Empresa Desconhecida' }}</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-info text-dark">{{ ucfirst($candidatura->status) }}</span></p>

                        <div class="mt-2">
                           <a href="{{ route('pse.jovens.show', ['jovem' => $candidatura->jovem->id, 'return_to_route' => 'pse.candidaturas.index']) }}" class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-person-fill me-1"></i>Ver Perfil do Jovem
                            </a>
                            <a href="{{ route('vagas.show', $candidatura->vaga->id) }}" class="btn btn-sm btn-secondary me-2">
                                <i class="bi bi-briefcase-fill me-1"></i>Ver Detalhes da Vaga
                            </a>
                            {{-- Funcionalidades futuras para gestão da candidatura pelo PSE (mudar status, etc.) --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $candidaturas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
