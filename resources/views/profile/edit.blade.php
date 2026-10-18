<x-app-layout>
    <div class="container py-4">
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
                <div class="card shadow-sm p-4 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input id="data_nascimento" class="form-control" type="date" name="data_nascimento" value="{{ old('data_nascimento', $user->jovem->data_nascimento) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input id="telefone" class="form-control" type="text" name="telefone" value="{{ old('telefone', $user->jovem->telefone) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="genero" class="form-label">Gênero</label>
                            <select id="genero" name="genero" class="form-select">
                                <option value="">Selecione...</option>
                                <option value="Masculino" {{ (old('genero', $user->jovem->genero) == 'Masculino') ? 'selected' : '' }}>Masculino</option>
                                <option value="Feminino" {{ (old('genero', $user->jovem->genero) == 'Feminino') ? 'selected' : '' }}>Feminino</option>
                                <option value="Outro" {{ (old('genero', $user->jovem->genero) == 'Outro') ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="deficiencia" class="form-label">Deficiência (descreva)</label>
                            <input id="deficiencia" class="form-control" type="text" name="deficiencia" value="{{ old('deficiencia', $user->jovem->deficiencia) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input id="endereco" class="form-control" type="text" name="endereco" value="{{ old('endereco', $user->jovem->endereco) }}" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input id="cidade" class="form-control" type="text" name="cidade" value="{{ old('cidade', $user->jovem->cidade) }}" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="estado" class="form-label">Estado (UF)</label>
                            <input id="estado" class="form-control" type="text" name="estado" value="{{ old('estado', $user->jovem->estado) }}" maxlength="2" />
                        </div>

                        <div class="col-12 mb-3">
                            <label for="formacao_academica" class="form-label">Formação Acadêmica</label>
                            <textarea id="formacao_academica" name="formacao_academica" class="form-control" rows="4">{{ old('formacao_academica', $user->jovem->formacao_academica) }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="experiencia_profissional" class="form-label">Experiência Profissional</label>
                            <textarea id="experiencia_profissional" name="experiencia_profissional" class="form-control" rows="4">{{ old('experiencia_profissional', $user->jovem->experiencia_profissional) }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="habilidades" class="form-label">Habilidades</label>
                            <textarea id="habilidades" name="habilidades" class="form-control" rows="3">{{ old('habilidades', $user->jovem->habilidades) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_portfolio" class="form-label">Link Portfólio (opcional)</label>
                            <input id="link_portfolio" class="form-control" type="url" name="link_portfolio" value="{{ old('link_portfolio', $user->jovem->link_portfolio) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_linkedin" class="form-label">Link LinkedIn (opcional)</label>
                            <input id="link_linkedin" class="form-control" type="url" name="link_linkedin" value="{{ old('link_linkedin', $user->jovem->link_linkedin) }}" />
                        </div>

                        <div class="col-12 mb-3">
                            <label for="curriculo" class="form-label">Upload de Currículo (PDF)</label>
                            <input id="curriculo" type="file" name="curriculo" class="form-control" accept="application/pdf" />
                            @if ($user->jovem->curriculo_path)
                                <p class="text-muted mt-2">
                                    Currículo atual: <a href="{{ Storage::url($user->jovem->curriculo_path) }}" target="_blank" class="text-primary">Visualizar</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- Formulário para EMPRESA --}}
            @elseif ($user->tipo_perfil === 'empresa' && $user->empresa)
                <div class="card shadow-sm p-4 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="razao_social" class="form-label">Razão Social</label>
                            <input id="razao_social" class="form-control" type="text" name="razao_social" value="{{ old('razao_social', $user->empresa->razao_social) }}" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                            <input id="nome_fantasia" class="form-control" type="text" name="nome_fantasia" value="{{ old('nome_fantasia', $user->empresa->nome_fantasia) }}" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input id="cnpj" class="form-control" type="text" name="cnpj" value="{{ old('cnpj', $user->empresa->cnpj) }}" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone_empresa" class="form-label">Telefone da Empresa</label>
                            <input id="telefone_empresa" class="form-control" type="text" name="telefone_empresa" value="{{ old('telefone_empresa', $user->empresa->telefone) }}" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email_contato" class="form-label">E-mail de Contato</label>
                            <input id="email_contato" class="form-control" type="email" name="email_contato" value="{{ old('email_contato', $user->empresa->email_contato) }}" required />
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
