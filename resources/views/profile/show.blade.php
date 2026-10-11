<x-app-layout>
    <div class="container py-4">
    
        {{-- Exibe a mensagem de status (sucesso) --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 border border-green-400 rounded-md p-3">
                {{ session('status') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Meu Perfil</h1>

        <p>Bem-vindo(a), {{ Auth::user()->name }}!</p>
        {{-- LINHA TEMPORÁRIA ADICIONADA AQUI --}}
        
        <p>Seu e-mail: {{ Auth::user()->email }}</p>
        <p>Seu tipo de perfil: <strong>{{ Auth::user()->tipo_perfil }}</strong>.</p>
        <hr class="my-4">

        @if (Auth::user()->tipo_perfil === 'jovem' && Auth::user()->jovem)
            <h2 class="text-xl font-semibold mb-3">Detalhes do Perfil Jovem</h2>
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <p><strong>Telefone:</strong> {{ Auth::user()->jovem->telefone ?? 'Não informado' }}</p>
                <p><strong>Data de Nascimento:</strong> {{ Auth::user()->jovem->data_nascimento ? \Carbon\Carbon::parse(Auth::user()->jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                <p><strong>Cidade/Estado:</strong> {{ Auth::user()->jovem->cidade ?? 'Não informado' }}/{{ Auth::user()->jovem->estado ?? 'Não informado' }}</p>
                <p><strong>Escolaridade:</strong> {{ Auth::user()->jovem->escolaridade ?? 'Não informado' }}</p>
                <p><strong>Deficiência:</strong> {{ Auth::user()->jovem->deficiencia ?? 'Não informado' }}</p>
                <p><strong>Área de Interesse:</strong> {{ Auth::user()->jovem->area_interesse ?? 'Não informado' }}</p>
                <p><strong>Experiência Profissional:</strong> {{ Auth::user()->jovem->experiencia_profissional ?? 'Não informado' }}</p>

                {{-- Exibe o link para o Currículo PDF --}}
                <p><strong>Currículo PDF:</strong>
                    @if (Auth::user()->jovem->curriculo_path)
                        <a href="{{ Storage::url(Auth::user()->jovem->curriculo_path) }}" target="_blank" class="text-blue-500 hover:underline">Visualizar Currículo</a>
                    @else
                        Não enviado
                    @endif
                </p>
            </div>
        @elseif (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->empresa)
            <h2 class="text-xl font-semibold mb-3">Detalhes do Perfil Empresa</h2>
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <p><strong>Razão Social:</strong> {{ Auth::user()->empresa->razao_social ?? 'Não informado' }}</p>
                <p><strong>Nome Fantasia:</strong> {{ Auth::user()->empresa->nome_fantasia ?? 'Não informado' }}</p>
                <p><strong>CNPJ:</strong> {{ Auth::user()->empresa->cnpj ?? 'Não informado' }}</p>
                <p><strong>Telefone:</strong> {{ Auth::user()->empresa->telefone ?? 'Não informado' }}</p>
                <p><strong>Email de Contato:</strong> {{ Auth::user()->empresa->email_contato ?? 'Não informado' }}</p>
                <p><strong>Cidade/Estado:</strong> {{ Auth::user()->empresa->cidade ?? 'Não informado' }}/{{ Auth::user()->empresa->estado ?? 'Não informado' }}</p>
                <p><strong>Ramo de Atividade:</strong> {{ Auth::user()->empresa->ramo_atividade ?? 'Não informado' }}</p>
                <p><strong>Website:</strong> {{ Auth::user()->empresa->website ?? 'Não informado' }}</p>
                <p><strong>Descrição:</strong> {{ Auth::user()->empresa->descricao ?? 'Não informado' }}</p>
            </div>
        @else
            <p class="text-red-500">Nenhum detalhe de perfil encontrado para seu tipo de perfil.</p>
        @endif

        {{-- Botão para Editar Perfil --}}
        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150" style="background-color: var(--pcdtop-dark-blue); color: white;">
                Editar Perfil
            </a>
        </div>
    </div>
</x-app-layout>
