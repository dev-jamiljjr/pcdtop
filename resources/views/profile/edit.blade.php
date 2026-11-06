<x-app-layout>
    <div class="container py-4">
        {{-- ADICIONA O ALERTA DE STATUS BLOQUEADO --}}
        @if(Auth::user()->isBlocked())
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">Cadastro realizado!</h4>
                <p class="mb-0">Aguardando aprovação...</p>
            </div>
        @endif

        <h1 class="h2 mb-4">Editar Perfil</h1>
        <hr class="my-4">

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Exibe mensagens de erro de validação --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <h5 class="alert-heading">Opa! Algo deu errado.</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Seção de Dados de Acesso (Comum a todos) --}}
            <h3 class="h4 mb-3">Dados de Acesso</h3>
            <div class="card shadow-sm p-4 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Nome') }}</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                    </div>
                </div>
            </div>

            <h3 class="h4 mb-3 mt-4">Informações Específicas do Perfil</h3>

            {{-- Formulário para JOVEM --}}
            @if ($user->tipo_perfil === 'jovem' && $user->jovem)
                {{-- O formulário do jovem permanece o mesmo --}}
                <div class="card shadow-sm p-4 mb-4">
                    {{-- ... (código do formulário do jovem) ... --}}
                </div>

            {{-- Formulário para EMPRESA --}}
            @elseif ($user->tipo_perfil === 'empresa' && $user->empresa)
                {{-- Dados da Empresa --}}
                <div class="card shadow-sm p-4 mb-4">
                    <h4 class="mb-3">Dados da Empresa</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="razao_social" class="form-label">Razão Social</label>
                            <input id="razao_social" class="form-control" type="text" name="razao_social" value="{{ old('razao_social', $user->empresa->razao_social) }}" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                            <input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" value="{{ old('nome_fantasia', $user->empresa->nome_fantasia) }}" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input id="cnpj" class="form-control" type="text" name="cnpj" value="{{ old('cnpj', $user->empresa->cnpj) }}" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="telefone" class="form-label">Telefone da Empresa</label>
                            <input id="telefone" class="form-control" type="text" name="telefone" value="{{ old('telefone', $user->empresa->telefone) }}" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email_contato" class="form-label">E-mail Principal de Contato</label>
                            <input id="email_contato" class="form-control" type="email" name="email_contato" value="{{ old('email_contato', $user->empresa->email_contato) }}" required />
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="website" class="form-label">Website (opcional)</label>
                            <input id="website" class="form-control" type="url" name="website" value="{{ old('website', $user->empresa->website) }}" placeholder="https://www.suaempresa.com.br" />
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    <h5 class="mb-3">Endereço da Empresa</h5>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input id="endereco" class="form-control" type="text" name="endereco" value="{{ old('endereco', $user->empresa->endereco) }}" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input id="bairro" class="form-control" type="text" name="bairro" value="{{ old('bairro', $user->empresa->bairro) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input id="cidade" class="form-control" type="text" name="cidade" value="{{ old('cidade', $user->empresa->cidade) }}" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="estado" class="form-label">Estado (UF)</label>
                            <input id="estado" class="form-control" type="text" name="estado" value="{{ old('estado', $user->empresa->estado) }}" maxlength="2" />
                        </div>
                         <div class="col-md-4 mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input id="cep" class="form-control" type="text" name="cep" value="{{ old('cep', $user->empresa->cep) }}" />
                        </div>
                    </div>
                </div>

                {{-- Contatos da Empresa --}}
                @php
                    $primeiro_contato = $user->empresa->contatos->get(0);
                    $segundo_contato = $user->empresa->contatos->get(1);
                @endphp

                <div class="card shadow-sm p-4 mb-4">
                    <h4 class="mb-3">Contatos de Referência (Até 2)</h4>
                    
                    {{-- Contato 1 --}}
                    <div class="border rounded p-3 mb-3">
                        <h5 class="mb-3">Contato 1</h5>
                        <input type="hidden" name="contatos[0][id]" value="{{ $primeiro_contato->id ?? '' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contato_1_nome" class="form-label">Nome Completo</label>
                                <input id="contato_1_nome" class="form-control" type="text" name="contatos[0][nome]" value="{{ old('contatos.0.nome', $primeiro_contato->nome ?? '') }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contato_1_cargo" class="form-label">Cargo</label>
                                <input id="contato_1_cargo" class="form-control" type="text" name="contatos[0][cargo]" value="{{ old('contatos.0.cargo', $primeiro_contato->cargo ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_1_cpf" class="form-label">CPF</label>
                                <input id="contato_1_cpf" class="form-control" type="text" name="contatos[0][cpf]" value="{{ old('contatos.0.cpf', $primeiro_contato->cpf ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_1_telefone" class="form-label">Telefone</label>
                                <input id="contato_1_telefone" class="form-control" type="text" name="contatos[0][telefone]" value="{{ old('contatos.0.telefone', $primeiro_contato->telefone ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_1_email" class="form-label">E-mail</label>
                                <input id="contato_1_email" class="form-control" type="email" name="contatos[0][email]" value="{{ old('contatos.0.email', $primeiro_contato->email ?? '') }}" />
                            </div>
                        </div>
                    </div>

                    {{-- Contato 2 --}}
                    <div class="border rounded p-3">
                        <h5 class="mb-3">Contato 2 (Opcional)</h5>
                        <input type="hidden" name="contatos[1][id]" value="{{ $segundo_contato->id ?? '' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contato_2_nome" class="form-label">Nome Completo</label>
                                <input id="contato_2_nome" class="form-control" type="text" name="contatos[1][nome]" value="{{ old('contatos.1.nome', $segundo_contato->nome ?? '') }}" />
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="contato_2_cargo" class="form-label">Cargo</label>
                                <input id="contato_2_cargo" class="form-control" type="text" name="contatos[1][cargo]" value="{{ old('contatos.1.cargo', $segundo_contato->cargo ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_2_cpf" class="form-label">CPF</label>
                                <input id="contato_2_cpf" class="form-control" type="text" name="contatos[1][cpf]" value="{{ old('contatos.1.cpf', $segundo_contato->cpf ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_2_telefone" class="form-label">Telefone</label>
                                <input id="contato_2_telefone" class="form-control" type="text" name="contatos[1][telefone]" value="{{ old('contatos.1.telefone', $segundo_contato->telefone ?? '') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="contato_2_email" class="form-label">E-mail</label>
                                <input id="contato_2_email" class="form-control" type="email" name="contatos[1][email]" value="{{ old('contatos.1.email', $segundo_contato->email ?? '') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex align-items-center mt-4">
                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    Salvar Alterações
                </button>
                <a href="{{ route('profile.show') }}" class="btn btn-secondary ms-3">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
