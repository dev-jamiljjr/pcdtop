<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-2xl font-bold">Minhas Vagas</h1>
            <a href="{{ route('vagas.create') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue); color: white;">
                <i class="bi bi-plus-circle me-2"></i>Nova Vaga
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($vagas->isEmpty())
            <div class="alert alert-info">Você ainda não cadastrou nenhuma vaga. Clique em "Nova Vaga" para começar.</div>
        @else
            <div class="list-group">
                @foreach ($vagas as $vaga)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 font-weight-bold">{{ $vaga->titulo }}</h5>
                            <small class="text-muted">{{ $vaga->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($vaga->descricao, 100) }}</p>
                        <small class="text-muted">{{ $vaga->localizacao }} - {{ $vaga->tipo_contrato }}</small>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('vagas.edit', $vaga) }}" class="btn btn-sm btn-outline-secondary me-2">
                                    <i class="bi bi-pencil-fill me-1"></i>Editar
                                </a>
                                <form action="{{ route('vagas.destroy', $vaga) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta vaga?')">
                                        <i class="bi bi-trash-fill me-1"></i>Excluir
                                    </button>
                                </form>
                            </div>
                            <div>
                                {{-- Novo botão para ver candidatos --}}
                                <a href="{{ route('vagas.candidatos.index', $vaga->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-people-fill me-1"></i>
                                    Ver Candidatos <span class="badge bg-light text-dark">{{ $vaga->candidaturas_count }}</span>
                                </a>

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
