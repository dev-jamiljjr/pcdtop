<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('vagas.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Minhas Vagas
        </a>
        <h1 class="h2 mb-4">Candidatos para: "{{ $vaga->titulo }}"</h1>
        <h2 class="h4 text-muted mb-4">{{ $vaga->empresa->nome_fantasia }}</h2>
        <hr class="my-4">

        {{-- Exibição de mensagens de status (sucesso ou erro) --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                        
                        <div class="d-flex align-items-center mb-2">
                            <label for="status-{{ $candidatura->id }}" class="form-label me-2 mb-0">Status:</label>
                            <form action="{{ route('vagas.candidatos.updateStatus', ['vaga' => $vaga->id, 'candidatura' => $candidatura->id]) }}" method="POST" class="d-inline-flex">
                                @csrf
                                <select name="status" id="status-{{ $candidatura->id }}" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach (\App\Models\Candidatura::STATUS_LABELS as $value => $label)
                                        <option value="{{ $value }}" {{ $candidatura->status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

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
