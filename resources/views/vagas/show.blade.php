<x-app-layout>
    <div class="container py-4">
        {{-- Mensagens de Feedback --}}
        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning mb-4" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        <a href="{{ Auth::user()->tipo_perfil === 'jovem' ? route('vagas.search') : route('vagas.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar
        </a>
        <h1 class="text-2xl font-bold mb-3">{{ $vaga->titulo }}</h1>
        <h2 class="text-xl text-muted mb-4">{{ $vaga->empresa->nome_fantasia ?? 'Empresa Desconhecida' }}</h2>
        <hr class="my-4">

        <div class="row">
            <div class="col-md-8">
                <p class="text-lg"><strong>Descrição:</strong></p>
                <p class="mb-4">{{ $vaga->descricao }}</p>

                @if ($vaga->requisitos)
                    <p class="text-lg"><strong>Requisitos:</strong></p>
                    <p class="mb-4">{{ $vaga->requisitos }}</p>
                @endif

                @if ($vaga->beneficios)
                    <p class="text-lg"><strong>Benefícios:</strong></p>
                    <p class="mb-4">{{ $vaga->beneficios }}</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Detalhes da Vaga
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="bi bi-geo-alt-fill me-2"></i>Localização: {{ $vaga->localizacao }}</li>
                        <li class="list-group-item"><i class="bi bi-briefcase-fill me-2"></i>Tipo de Contrato: {{ $vaga->tipo_contrato }}</li>
                        @if($vaga->salario)
                            <li class="list-group-item"><i class="bi bi-cash me-2"></i>Salário: R$ {{ number_format($vaga->salario, 2, ',', '.') }}</li>
                        @endif
                        <li class="list-group-item"><i class="bi bi-calendar-event me-2"></i>Publicado: {{ $vaga->created_at->format('d/m/Y') }}</li>
                    </ul>
                    <div class="card-body">
                        @if (Auth::user()->tipo_perfil === 'jovem')
                            @if ($candidatado)
                                <button type="button" class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-check-circle me-2"></i>Já Candidatado
                                </button>
                            @else
                                <form action="{{ route('vagas.apply', $vaga->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-2"></i>Candidatar-se
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
