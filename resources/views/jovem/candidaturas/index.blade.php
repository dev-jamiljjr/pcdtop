<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Minhas Candidaturas</h1>
        <hr class="my-4">

        @if ($candidaturas->isEmpty())
            <div class="alert alert-info" role="alert">
                Você ainda não se candidatou a nenhuma vaga. Explore as <a href="{{ route('vagas.search') }}">vagas disponíveis</a>!
            </div>
        @else
            <div class="list-group">
                @foreach ($candidaturas as $candidatura)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-bold">
                                {{ $candidatura->vaga->titulo }}
                            </h5>
                            <small class="text-muted">Candidatou-se em: {{ $candidatura->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-1 text-muted">Empresa: {{ $candidatura->vaga->empresa->nome_fantasia }}</p>
                        <p class="mb-1">
                            Status: 
                            <span class="badge 
                                @switch($candidatura->status)
                                    @case(\App\Models\Candidatura::STATUS_APROVADO)
                                        bg-success
                                        @break
                                    @case(\App\Models\Candidatura::STATUS_REJEITADO)
                                        bg-danger
                                        @break
                                    @case(\App\Models\Candidatura::STATUS_ENTREVISTA)
                                    @case(\App\Models\Candidatura::STATUS_EM_ANALISE)
                                        bg-primary
                                        @break
                                    @case(\App\Models\Candidatura::STATUS_VISUALIZADO)
                                        bg-info text-dark
                                        @break
                                    @default
                                        bg-secondary
                                @endswitch
                                text-white">
                                {{ $candidatura->status_label }}
                            </span>
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('vagas.show', $candidatura->vaga->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye-fill me-1"></i>Ver Detalhes da Vaga
                            </a>
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
