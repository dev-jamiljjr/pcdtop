<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Vagas Cadastradas (PSE)</h1>
        <hr class="my-4">

        @if ($vagas->isEmpty())
            <div class="alert alert-info">Nenhuma vaga cadastrada ainda.</div>
        @else
            <div class="list-group">
                @foreach ($vagas as $vaga)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 font-weight-bold">{{ $vaga->titulo }}</h5>
                            <small class="text-muted">Empresa: {{ $vaga->empresa->nome_fantasia ?? 'N/A' }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($vaga->descricao, 100) }}</p>
                        <small class="text-muted">Localização: {{ $vaga->localizacao }} | Tipo: {{ $vaga->tipo_contrato }} | Status: {{ $vaga->status }}</small>
                        <p class="mb-1">Publicado por: {{ $vaga->empresa->user->name ?? 'N/A' }} ({{ $vaga->empresa->user->email ?? 'N/A' }})</p>
                        <a href="{{ route('vagas.show', $vaga) }}" class="btn btn-sm btn-outline-primary mt-2">Ver Detalhes</a>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
