<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Painel
        </a>

        <h1 class="h2 mb-4">Jovens Cadastrados (PSE)</h1>
        <hr class="my-4">

        @if ($jovens->isEmpty())
            <div class="alert alert-info">Nenhum jovem cadastrado ainda.</div>
        @else
            <div class="list-group">
                @foreach ($jovens as $jovemUser)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 font-weight-bold">{{ $jovemUser->name }}</h5>
                            <small class="text-muted">ID: {{ $jovemUser->id }}</small>
                        </div>
                        <p class="mb-1"><strong>E-mail:</strong> {{ $jovemUser->email }}</p>
                        @if ($jovemUser->jovem)
                            <p class="mb-1"><strong>Telefone:</strong> {{ $jovemUser->jovem->telefone ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Cidade/Estado:</strong> {{ $jovemUser->jovem->cidade ?? 'N/A' }}/{{ $jovemUser->jovem->estado ?? 'N/A' }}</p>
                            <div class="mt-3">
                                <a href="{{ route('pse.jovens.show', ['jovem' => $jovemUser->jovem->id, 'return_to_route' => 'pse.jovens.index']) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-person-lines-fill me-1"></i>Ver Perfil Completo
                                </a>
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
