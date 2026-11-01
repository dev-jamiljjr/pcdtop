<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Painel
        </a>

        <h1 class="h2 mb-4">Empresas Cadastradas (PSE)</h1>
        <hr class="my-4">

        @if ($empresas->isEmpty())
            <div class="alert alert-info">Nenhuma empresa cadastrada ainda.</div>
        @else
            <div class="list-group">
                @foreach ($empresas as $empresaUser)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 font-weight-bold">{{ $empresaUser->empresa->nome_fantasia ?? $empresaUser->name }}</h5>
                            <small class="text-muted">ID: {{ $empresaUser->id }} | E-mail: {{ $empresaUser->email }}</small>
                        </div>
                        <p class="mb-1">Perfil: {{ $empresaUser->tipo_perfil }}</p>
                        @if ($empresaUser->empresa)
                            <p class="mb-1">Razão Social: {{ $empresaUser->empresa->razao_social ?? 'N/A' }}</p>
                            <p class="mb-1">CNPJ: {{ $empresaUser->empresa->cnpj ?? 'N/A' }}</p>
                            <p class="mb-1">Telefone: {{ $empresaUser->empresa->telefone ?? 'N/A' }}</p>
                            <p class="mb-1">Cidade/Estado: {{ $empresaUser->empresa->cidade ?? 'N/A' }}/{{ $empresaUser->empresa->estado ?? 'N/A' }}</p>
                            <div class="mt-2">
                                <a href="{{ route('pse.empresas.show', $empresaUser->empresa->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill me-1"></i>Ver Detalhes
                                </a>
                            </div>
                        @else
                            <p class="text-danger">Detalhes do perfil empresa não disponíveis.</p>
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
