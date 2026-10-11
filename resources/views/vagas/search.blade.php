<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Buscar Vagas</h1>
        <hr class="my-4">

        @if ($vagas->isEmpty())
            <div class="alert alert-info">Nenhuma vaga encontrada no momento.</div>
        @else
            <div class="row">
                @foreach ($vagas as $vaga)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">{{ $vaga->titulo }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $vaga->empresa->nome_fantasia ?? 'Empresa Desconhecida' }}</h6>
                                <p class="card-text">{{ Str::limit($vaga->descricao, 150) }}</p>
                                <ul class="list-unstyled text-sm">
                                    <li><i class="bi bi-geo-alt-fill me-2"></i>{{ $vaga->localizacao }}</li>
                                    <li><i class="bi bi-briefcase-fill me-2"></i>{{ $vaga->tipo_contrato }}</li>
                                    @if($vaga->salario)
                                        <li><i class="bi bi-cash me-2"></i>R$ {{ number_format($vaga->salario, 2, ',', '.') }}</li>
                                    @endif
                                </ul>
                                <a href="{{ route('vagas.show', $vaga) }}" class="btn btn-sm btn-outline-primary mt-2">Ver Detalhes</a>
                            </div>
                            <div class="card-footer text-muted text-sm">
                                Publicado {{ $vaga->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
