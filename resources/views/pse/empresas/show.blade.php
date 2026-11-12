<x-app-layout>
    <div class="container py-4">
        <a href="{{ session('pse_users_return_url', route('pse.empresas.index')) }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para a Lista
        </a>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h2 mb-0">Detalhes da Empresa: {{ $empresa->nome_fantasia ?? $empresa->user->name }}</h1>
            <div class="d-flex align-items-center gap-3">
                @if ($empresa->user->isActive())
                    <span class="badge bg-success fs-6">Status: Ativa</span>
                @else
                    <span class="badge bg-danger fs-6">Status: Bloqueada</span>
                @endif
                <form action="{{ route('pse.users.toggle-status', $empresa->user->id) }}" method="POST">
                    @csrf
                    @if ($empresa->user->isActive())
                        <button type="submit" class="btn btn-sm btn-warning" title="Bloquear acesso da empresa">
                            <i class="bi bi-lock-fill me-1"></i>Bloquear
                        </button>
                    @else
                        <button type="submit" class="btn btn-sm btn-success" title="Ativar acesso da empresa">
                            <i class="bi bi-unlock-fill me-1"></i>Ativar
                        </button>
                    @endif
                </form>
            </div>
        </div>
        <hr class="my-4">

        <div class="card shadow-sm p-4 mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="h6 text-muted">Informações Gerais</h5>
                    <p><strong>Razão Social:</strong> {{ $empresa->razao_social ?? 'Não informado' }}</p>
                    <p><strong>Nome Fantasia:</strong> {{ $empresa->nome_fantasia ?? 'Não informado' }}</p>
                    <p><strong>CNPJ:</strong> {{ $empresa->cnpj_formatado ?? $empresa->cnpj ?? 'Não informado' }}</p>
                    <p><strong>Website:</strong> 
                        @if($empresa->website)
                            <a href="{{ $empresa->website }}" target="_blank">{{ $empresa->website }}</a>
                        @else
                            Não informado
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="h6 text-muted">Contato Principal</h5>
                    <p><strong>E-mail (Login):</strong> {{ $empresa->user->email ?? 'N/A' }}</p>
                    <p><strong>E-mail de Contato:</strong> {{ $empresa->email_contato ?? 'Não informado' }}</p>
                    <p><strong>Telefone:</strong> {{ $empresa->telefone ?? 'Não informado' }}</p>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="h6 text-muted">Endereço</h5>
                    <p><strong>Endereço:</strong> {{ $empresa->endereco ?? 'Não informado' }}</p>
                    <p><strong>Bairro:</strong> {{ $empresa->bairro ?? 'Não informado' }}</p>
                    <p><strong>Cidade/Estado:</strong> {{ ($empresa->cidade && $empresa->estado) ? $empresa->cidade . '/' . $empresa->estado : 'Não informado' }}</p>
                    <p><strong>CEP:</strong> {{ $empresa->cep_formatado ?? $empresa->cep ?? 'Não informado' }}</p>
                </div>
            </div>
            
            @if ($empresa->contatos->isNotEmpty())
                <hr class="my-3">
                <h5 class="h6 text-muted mb-3">Contatos Adicionais</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empresa->contatos as $contato)
                                <tr>
                                    <td>{{ $contato->nome }}</td>
                                    <td>{{ $contato->cargo ?? 'N/A' }}</td>
                                    <td>{{ $contato->cpf_formatado ?? $contato->cpf ?? 'N/A' }}</td>
                                    <td>{{ $contato->telefone ?? 'N/A' }}</td>
                                    <td>{{ $contato->email ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <hr class="my-3">
                <p class="text-muted">Nenhum contato adicional cadastrado.</p>
            @endif

        </div>
    </div>
</x-app-layout>
