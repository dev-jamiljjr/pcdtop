<x-app-layout>
    <div class="container py-4">

        {{-- Mensagens de status e boas-vindas --}}
        @if (session('status_registro'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <h4 class="alert-heading">Seja bem-vindo(a) ao PCD TOP! 💙</h4>
                <p>{{ session('status_registro') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('status') && session('status') !== 'profile-deleted')
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alerta de status bloqueado --}}
        @if(Auth::user()->isBlocked() && Auth::user()->tipo_perfil !== 'pse')
            <div class="alert alert-warning text-center mb-4" role="alert">
                <h4 class="alert-heading">Acesso restrito!</h4>
                <p class="mb-0">Aguardando aprovação...</p>
            </div>
        @endif

        <h1 class="h2 mb-4">Meu Perfil</h1>

        <p class="mb-1">Bem-vindo(a), <strong class="text-primary">{{ Auth::user()->name }}</strong>!</p>
        <p class="mb-1">E-mail: <strong class="text-primary">{{ Auth::user()->email }}</strong></p>
        <p>Tipo de perfil: <strong class="text-primary">{{ Auth::user()->tipo_perfil }}</strong>.</p>
        <hr class="my-4">

        {{-- Detalhes do Perfil Jovem --}}
        @if (Auth::user()->tipo_perfil === 'jovem' && Auth::user()->jovem)
            @php $jovem = Auth::user()->jovem; @endphp
            <h2 class="h4 mb-3">Detalhes do Perfil</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Informações Pessoais</h5>
                        <p><strong>CPF:</strong> {{ $jovem->cpf_formatado ?? 'Não informado' }}</p>
                        <p><strong>Telefone:</strong> {{ $jovem->telefone ?? 'Não informado' }}</p>
                        <p><strong>Data de Nasc.:</strong> {{ $jovem->data_nascimento ? \Carbon\Carbon::parse($jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                        <p><strong>Gênero:</strong> {{ $jovem->genero ?? 'Não informado' }}</p>
                        <p><strong>Endereço:</strong> {{ $jovem->endereco ?? 'Não informado' }}</p>
                        <p><strong>Cidade/Estado:</strong> {{ $jovem->cidade ?? 'Não informado' }}/{{ $jovem->estado ?? 'Não informado' }}</p>
                        <p><strong>Deficiência:</strong> {{ $jovem->deficiencia ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Informações Profissionais</h5>
                        <p><strong>Formação Acadêmica:</strong></p>
                        <p style="white-space: pre-wrap;">{{ $jovem->formacao_academica ?? 'Não informado' }}</p>
                        <p><strong>Experiência Profissional:</strong></p>
                        <p style="white-space: pre-wrap;">{{ $jovem->experiencia_profissional ?? 'Não informado' }}</p>
                        <p><strong>Habilidades:</strong></p>
                        <p style="white-space: pre-wrap;">{{ $jovem->habilidades ?? 'Não informado' }}</p>
                        @if ($jovem->link_portfolio)
                            <p><strong>Portfólio:</strong> <a href="{{ $jovem->link_portfolio }}" target="_blank" class="text-primary">Ver Portfólio</a></p>
                        @endif
                        @if ($jovem->link_linkedin)
                            <p><strong>LinkedIn:</strong> <a href="{{ $jovem->link_linkedin }}" target="_blank" class="text-primary">Ver LinkedIn</a></p>
                        @endif
                        <p class="mt-3"><strong>Currículo PDF:</strong>
                            @if ($jovem->curriculo_path)
                                <a href="{{ Storage::url($jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white">Visualizar Currículo</a>
                            @else
                                Não enviado
                            @endif
                        </p>
                    </div>
                </div>
            </div>

        {{-- Detalhes do Perfil Empresa --}}
        @elseif (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->empresa)
            @php $empresa = Auth::user()->empresa; @endphp
            <h2 class="h4 mb-3">Detalhes do Perfil</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="h6 text-muted">Informações Gerais</h5>
                        <p><strong>Razão Social:</strong> {{ $empresa->razao_social ?? 'Não informado' }}</p>
                        <p><strong>Nome Fantasia:</strong> {{ $empresa->nome_fantasia ?? 'Não informado' }}</p>
                        <p><strong>CNPJ:</strong> {{ $empresa->cnpj ?? 'Não informado' }}</p>
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
                        <p><strong>CEP:</strong> {{ $empresa->cep ?? 'Não informado' }}</p>
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
                                        <td>{{ $contato->cpf ?? 'N/A' }}</td>
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

        @elseif (Auth::user()->tipo_perfil === 'pse')
            <div class="alert alert-info">Esta é uma conta administrativa. Use o painel para gerenciar o sistema.</div>
        @endif

        {{-- Botões de Ação --}}
        <div class="mt-4 d-flex gap-2">
            @if (Auth::user()->tipo_perfil === 'jovem')
                <a href="{{ route('jovem.curriculo.step1') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    <i class="bi bi-pencil-square me-2"></i>Editar Perfil / Currículo
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    <i class="bi bi-pencil-square me-2"></i>Editar Cadastro
                </a>
            @endif

            @if(in_array(Auth::user()->tipo_perfil, ['jovem', 'empresa']))
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                    <i class="bi bi-trash me-2"></i>Excluir Conta
                </button>
            @endif
        </div>
    </div>

    {{-- Modal de confirmação de exclusão --}}
    @if(in_array(Auth::user()->tipo_perfil, ['jovem', 'empresa']))
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">Confirmar Exclusão de Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir sua conta? Esta ação é irreversível.</p>
                        <p class="text-danger fw-bold">Todos os seus dados e informações de perfil serão removidos permanentemente.</p>

                        <div class="mb-3">
                            <label for="password_confirm_delete" class="form-label visually-hidden">Confirme sua Senha</label>
                            <input id="password_confirm_delete" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Confirme sua senha" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir Conta Permanentemente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
