<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Editar Perfil</h1>
        <hr class="my-4">

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Seção de Dados de Acesso (Comum a todos) --}}
            <h3 class="text-xl font-semibold mb-3">Dados de Acesso</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                <div class="mb-3">
                    <x-input-label for="name" :value="__('auth.Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div class="mb-3">
                    <x-input-label for="email" :value="__('auth.Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>

            <h3 class="text-xl font-semibold mb-3 mt-6">Informações Específicas do Perfil</h3>

            {{-- Formulário para JOVEM --}}
            @if ($user->tipo_perfil === 'jovem' && $user->jovem)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                    <div class="mb-3">
                        <x-input-label for="data_nascimento" value="Data de Nascimento" />
                        <x-text-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" :value="old('data_nascimento', $user->jovem->data_nascimento)" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="telefone" value="Telefone" />
                        <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone', $user->jovem->telefone)" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="cidade" value="Cidade" />
                        <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade', $user->jovem->cidade)" />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="estado" value="Estado (UF)" />
                        <x-text-input id="estado" class="block mt-1 w-full" type="text" name="estado" :value="old('estado', $user->jovem->estado)" maxlength="2" />
                    </div>
                    <div class="md:col-span-2 mb-3">
                        <x-input-label for="escolaridade" value="Escolaridade" />
                        <x-text-input id="escolaridade" class="block mt-1 w-full" type="text" name="escolaridade" :value="old('escolaridade', $user->jovem->escolaridade)" />
                    </div>
                    <div class="md:col-span-2 mb-3">
                        <x-input-label for="deficiencia" value="Deficiência (se aplicável)" />
                        <x-text-input id="deficiencia" class="block mt-1 w-full" type="text" name="deficiencia" :value="old('deficiencia', $user->jovem->deficiencia)" />
                    </div>
                    <div class="md:col-span-2 mb-3">
                        <x-input-label for="area_interesse" value="Área de Interesse Profissional" />
                        <x-text-input id="area_interesse" class="block mt-1 w-full" type="text" name="area_interesse" :value="old('area_interesse', $user->jovem->area_interesse)" />
                    </div>
                    <div class="md:col-span-2 mb-3">
                        <x-input-label for="experiencia_profissional" value="Resumo da Experiência Profissional" />
                        <textarea id="experiencia_profissional" name="experiencia_profissional" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('experiencia_profissional', $user->jovem->experiencia_profissional) }}</textarea>
                    </div>
                </div>

            {{-- Formulário para EMPRESA --}}
            @elseif ($user->tipo_perfil === 'empresa' && $user->empresa)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                    <div class="mb-3">
                        <x-input-label for="razao_social" value="Razão Social" />
                        <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="old('razao_social', $user->empresa->razao_social)" required />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="nome_fantasia" value="Nome Fantasia" />
                        <x-text-input id="nome_fantasia" class="block mt-1 w-full" type="text" name="nome_fantasia" :value="old('nome_fantasia', $user->empresa->nome_fantasia)" required />
                    </div>
                     <div class="mb-3">
                        <x-input-label for="cnpj" value="CNPJ" />
                        <x-text-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj', $user->empresa->cnpj)" required />
                    </div>
                    <div class="mb-3">
                        <x-input-label for="telefone_empresa" value="Telefone da Empresa" />
                        <x-text-input id="telefone_empresa" class="block mt-1 w-full" type="text" name="telefone_empresa" :value="old('telefone_empresa', $user->empresa->telefone)" />
                    </div>
                     <div class="md:col-span-2 mb-3">
                        <x-input-label for="email_contato" value="E-mail de Contato" />
                        <x-text-input id="email_contato" class="block mt-1 w-full" type="email" name="email_contato" :value="old('email_contato', $user->empresa->email_contato)" required />
                    </div>
                </div>
            @endif

            <div class="flex items-center mt-4">
                <x-primary-button>
                    Salvar Alterações
                </x-primary-button>
                <a href="{{ route('profile.show') }}" class="ms-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
