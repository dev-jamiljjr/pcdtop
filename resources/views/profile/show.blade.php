<x-app-layout>
    <div class="container py-4">

        {{-- Mensagem de status (incluindo para exclusão) --}}
        @if (session('status') === 'profile-deleted')
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                Sua conta foi excluída com sucesso.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="h2 mb-4">Meu Perfil</h1>

        <p class="mb-1">Bem-vindo(a), <strong class="text-primary">{{ Auth::user()->name }}</strong>!</p>
        <p class="mb-1">Seu e-mail: <strong class="text-primary">{{ Auth::user()->email }}</strong></p>
        <p>Seu tipo de perfil: <strong class="text-primary">{{ Auth::user()->tipo_perfil }}</strong>.</p>
        <hr class="my-4">

        @if (Auth::user()->tipo_perfil === 'jovem' && Auth::user()->jovem)
            <h2 class="h4 mb-3">Detalhes do Perfil Jovem</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Dados Pessoais</h5>
                        <p><strong>CPF:</strong> {{ Auth::user()->jovem->cpf ?? 'Não informado' }}</p>
                        <p><strong>Data de Nascimento:</strong> {{ Auth::user()->jovem->data_nascimento ? \Carbon\Carbon::parse(Auth::user()->jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                        <p><strong>Telefone:</strong> {{ Auth::user()->jovem->telefone ?? 'Não informado' }}</p>
                        <p><strong>Gênero:</strong> {{ Auth::user()->jovem->genero ?? 'Não informado' }}</p>
                        <p><strong>Deficiência:</strong> {{ Auth::user()->jovem->deficiencia ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Endereço</h5>
                        <p><strong>Endereço:</strong> {{ Auth::user()->jovem->endereco ?? 'Não informado' }}</p>
                        <p><strong>Bairro:</strong> {{ Auth::user()->jovem->bairro ?? 'Não informado' }}</p>
                        <p><strong>Cidade/Estado:</strong> {{ (Auth::user()->jovem->cidade && Auth::user()->jovem->estado) ? Auth::user()->jovem->cidade . '/' . Auth::user()->jovem->estado : 'Não informado' }}</p>
                        <p><strong>CEP:</strong> {{ Auth::user()->jovem->cep ?? 'Não informado' }}</p>
                    </div>
                </div>
                <hr class="my-3">
                <div class="row">
                    <h5 class="h6 text-muted mb-2">Qualificação Profissional</h5>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Formação:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->formacao_academica ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Experiência Profissional:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->experiencia_profissional ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="mb-1"><strong>Habilidades:</strong></p>
                        <p class="text-muted" style="white-space: pre-wrap;">{{ Auth::user()->jovem->habilidades ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        @if (Auth::user()->jovem->link_portfolio)
                            <p><strong>Portfólio:</strong> <a href="{{ Auth::user()->jovem->link_portfolio }}" target="_blank" class="text-primary"><i class="bi bi-link-45deg me-1"></i>Ver Portfólio</a></p>
                        @else
                            <p><strong>Portfólio:</strong> Não informado</p>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        @if (Auth::user()->jovem->link_linkedin)
                            <p><strong>LinkedIn:</strong> <a href="{{ Auth::user()->jovem->link_linkedin }}" target="_blank" class="text-primary"><i class="bi bi-linkedin me-1"></i>Ver LinkedIn</a></p>
                        @else
                            <p><strong>LinkedIn:</strong> Não informado</p>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <p><strong>Currículo PDF:</strong>
                        @if (Auth::user()->jovem->curriculo_path)
                            <a href="{{ Storage::url(Auth::user()->jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="bi bi-file-earmark-pdf me-1"></i>Visualizar Currículo</a>
                        @else
                            <span class="text-muted">Não enviado</span>
                        @endif
                    </p>
                </div>
            </div>
        @elseif (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->empresa)
            <h2 class="h4 mb-3">Detalhes do Perfil Empresa</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Dados da Empresa</h5>
                        <p><strong>Razão Social:</strong> {{ Auth::user()->empresa->razao_social ?? 'Não informado' }}</p>
                        <p><strong>Nome Fantasia:</strong> {{ Auth::user()->empresa->nome_fantasia ?? 'Não informado' }}</p>
                        <p><strong>CNPJ:</strong> {{ Auth::user()->empresa->cnpj ?? 'Não informado' }}</p>
                        <p><strong>Email de Contato:</strong> {{ Auth::user()->empresa->email_contato ?? 'Não informado' }}</p>
                        <p><strong>Telefone:</strong> {{ Auth::user()->empresa->telefone ?? 'Não informado' }}</p>
                        <p><strong>Website:</strong>
                            @if(Auth::user()->empresa->website)
                                <a href="{{ Auth::user()->empresa->website }}" target="_blank" rel="noopener noreferrer">{{ Auth::user()->empresa->website }}</a>
                            @else
                                Não informado
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Endereço da Empresa</h5>
                        <p><strong>Endereço:</strong> {{ Auth::user()->empresa->endereco ?? 'Não informado' }}</p>
                        <p><strong>Bairro:</strong> {{ Auth::user()->empresa->bairro ?? 'Não informado' }}</p>
                        <p><strong>Cidade/Estado:</strong> {{ (Auth::user()->empresa->cidade && Auth::user()->empresa->estado) ? Auth::user()->empresa->cidade . '/' . Auth::user()->empresa->estado : 'Não informado' }}</p>
                        <p><strong>CEP:</strong> {{ Auth::user()->empresa->cep ?? 'Não informado' }}</p>
                    </div>
                </div>

                @if (Auth::user()->empresa->contatos->isNotEmpty())
                    <hr class="my-3">
                    <h5 class="h6 text-muted mb-2">Contatos da Empresa</h5>
                    @foreach (Auth::user()->empresa->contatos as $contato)
                        <div class="card card-body p-3 mb-2 bg-light">
                            <p class="mb-1"><strong>Nome:</strong> {{ $contato->nome ?? 'Não informado' }}</p>
                            <p class="mb-1"><strong>Cargo:</strong> {{ $contato->cargo ?? 'Não informado' }}</p>
                            <p class="mb-1"><strong>CPF:</strong> {{ $contato->cpf ?? 'Não informado' }}</p>
                            <p class="mb-1"><strong>Telefone:</strong> {{ $contato->telefone ?? 'Não informado' }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $contato->email ?? 'Não informado' }}</p>
                        </div>
                    @endforeach
                @else
                    <hr class="my-3">
                    <p class="text-muted">Nenhum contato cadastrado.</p>
                @endif
            </div>
        @elseif (Auth::user()->tipo_perfil === 'pse')
            <div class="alert alert-info">Esta é uma conta administrativa. Use o painel para gerenciar o sistema.</div>
        @endif

        <div class="mt-4 d-flex gap-2"> {{-- Div para alinhar botões --}}
            @if (Auth::user()->tipo_perfil === 'jovem')
                <a href="{{ route('jovem.curriculo.step1') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    <i class="bi bi-pencil-square me-2"></i>Editar Perfil / Currículo
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    <i class="bi bi-pencil-square me-2"></i>Editar Cadastro
                </a>
            @endif

            {{-- NOVO: Botão de exclusão (apenas para Jovem e Empresa) --}}
            @if(in_array(Auth::user()->tipo_perfil, ['jovem', 'empresa']))
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                    <i class="bi bi-trash me-2"></i>Excluir Conta
                </button>
            @endif
        </div>
    </div>

    {{-- NOVO: Modal de confirmação de exclusão --}}
    @if(in_array(Auth::user()->tipo_perfil, ['jovem', 'empresa']))
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">Confirmar Exclusão da Conta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja excluir sua conta? Esta ação é permanente e todos os seus dados serão removidos.</p>
                        <p>Para confirmar, por favor, digite sua senha:</p>
                        
                        <div class="mb-3">
                            <label for="password_delete" class="form-label">Senha</label>
                            <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password_delete" name="password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
