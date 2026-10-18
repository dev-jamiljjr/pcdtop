<x-app-layout>
    <div class="container py-4">

        {{-- Exibe a mensagem de status (sucesso) --}}
        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="h2 mb-4">Meu Perfil</h1>

        <p>Bem-vindo(a), {{ Auth::user()->name }}!</p>
        <p>Seu e-mail: {{ Auth::user()->email }}</p>
        <p>Seu tipo de perfil: <strong>{{ Auth::user()->tipo_perfil }}</strong>.</p>
        <hr class="my-4">

        @if (Auth::user()->tipo_perfil === 'jovem' && Auth::user()->jovem)
            <h2 class="h4 mb-3">Detalhes do Perfil Jovem</h2>
            <div class="card shadow-sm p-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>Data de Nascimento:</strong> {{ Auth::user()->jovem->data_nascimento ? \Carbon\Carbon::parse(Auth::user()->jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                        <p><strong>Telefone:</strong> {{ Auth::user()->jovem->telefone ?? 'Não informado' }}</p>
                        <p><strong>Gênero:</strong> {{ Auth::user()->jovem->genero ?? 'Não informado' }}</p>
                        <p><strong>Endereço:</strong> {{ Auth::user()->jovem->endereco ?? 'Não informado' }}</p>
                        <p><strong>Cidade/Estado:</strong> {{ Auth::user()->jovem->cidade ?? 'Não informado' }}/{{ Auth::user()->jovem->estado ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Deficiência:</strong> {{ Auth::user()->jovem->deficiencia ?? 'Não informado' }}</p>
                        <p><strong>Formação Acadêmica:</strong></p>
                        <p style="white-space: pre-wrap;">{{ Auth::user()->jovem->formacao_academica ?? 'Não informado' }}</p>
                        <p><strong>Habilidades:</strong></p>
                        <p style="white-space: pre-wrap;">{{ Auth::user()->jovem->habilidades ?? 'Não informado' }}</p>
                        @if (Auth::user()->jovem->link_portfolio)
                            <p><strong>Portfólio:</strong> <a href="{{ Auth::user()->jovem->link_portfolio }}" target="_blank" class="text-primary">Ver Portfólio</a></p>
                        @endif
                        @if (Auth::user()->jovem->link_linkedin)
                            <p><strong>LinkedIn:</strong> <a href="{{ Auth::user()->jovem->link_linkedin }}" target="_blank" class="text-primary">Ver LinkedIn</a></p>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Experiência Profissional:</strong></p>
                        <p style="white-space: pre-wrap;">{{ Auth::user()->jovem->experiencia_profissional ?? 'Não informado' }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <p><strong>Currículo PDF:</strong>
                        @if (Auth::user()->jovem->curriculo_path)
                            <a href="{{ Storage::url(Auth::user()->jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white">Visualizar Currículo</a>
                        @else
                            Não enviado
                        @endif
                    </p>
                </div>
            </div>
        @elseif (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->empresa)
            <h2 class="h4 mb-3">Detalhes do Perfil Empresa</h2>
            <div class="card shadow-sm p-4 mb-3">
                <p><strong>Razão Social:</strong> {{ Auth::user()->empresa->razao_social ?? 'Não informado' }}</p>
                <p><strong>Nome Fantasia:</strong> {{ Auth::user()->empresa->nome_fantasia ?? 'Não informado' }}</p>
                <p><strong>CNPJ:</strong> {{ Auth::user()->empresa->cnpj ?? 'Não informado' }}</p>
                <p><strong>Telefone:</strong> {{ Auth::user()->empresa->telefone ?? 'Não informado' }}</p>
                <p><strong>Email de Contato:</strong> {{ Auth::user()->empresa->email_contato ?? 'Não informado' }}</p>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                Editar Perfil
            </a>
        </div>
    </div>
</x-app-layout>
