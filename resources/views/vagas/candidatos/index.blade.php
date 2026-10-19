<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('vagas.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Minhas Vagas
        </a>
        <h1 class="h2 mb-4">Candidatos para: "{{ $vaga->titulo }}"</h1>
        <h2 class="h4 text-muted mb-4">{{ $vaga->empresa->nome_fantasia }}</h2>
        <hr class="my-4">

        @if ($candidaturas->isEmpty())
            <div class="alert alert-info">Ainda não há candidatos para esta vaga.</div>
        @else
            <div class="list-group">
                @foreach ($candidaturas as $candidatura)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 fw-bold">{{ $candidatura->jovem->user->name }}</h5>
                            <small class="text-muted">Candidatou-se em: {{ $candidatura->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-1">E-mail: {{ $candidatura->jovem->user->email }}</p>
                        <p class="mb-1">Telefone: {{ $candidatura->jovem->telefone ?? 'N/A' }}</p>
                        <p class="mb-1">Status da Candidatura: <span class="badge bg-info text-dark">{{ ucfirst($candidatura->status) }}</span></p>

                        <div class="mt-2">
                            {{-- Link para ver o perfil completo do jovem --}}
                            <a href="{{ route('vagas.candidatos.jovem.show', ['vaga' => $vaga->id, 'jovem' => $candidatura->jovem->id]) }}" class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-person-fill me-1"></i>Ver Perfil Completo
                            </a>

                            {{-- Link para ver/baixar o currículo PDF --}}
                            @if ($candidatura->jovem->curriculo_path)
                                <a href="{{ Storage::url($candidatura->jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>Ver Currículo PDF
                                </a>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>Currículo não enviado</button>
                            @endif
                            {{-- Funcionalidades futuras como mudar status, enviar mensagem, etc. --}}
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
