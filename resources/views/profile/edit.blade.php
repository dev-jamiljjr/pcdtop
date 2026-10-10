<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Editar Perfil</h1>

        <p>Editando perfil de: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->tipo_perfil }})</p>
        <hr class="my-4">

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT') {{-- Usamos PUT para atualizações --}}

            <!-- Campos Comuns (Nome e E-mail, apenas para exemplo) -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('auth.Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="Auth::user()->name" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="email" :value="__('auth.Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="Auth::user()->email" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <h3 class="text-xl font-semibold mb-3 mt-4">Informações Específicas do Perfil</h3>

            @if (Auth::user()->tipo_perfil === 'jovem')
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p>Formulário de edição para JOVEM (a ser preenchido)</p>
                    <!-- Exemplo: -->
                    <div class="mb-3">
                        <x-input-label for="data_nascimento" value="Data de Nascimento" />
                        <x-text-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" :value="Auth::user()->jovem->data_nascimento ?? ''" />
                    </div>
                </div>
            @elseif (Auth::user()->tipo_perfil === 'empresa')
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p>Formulário de edição para EMPRESA (a ser preenchido)</p>
                    <!-- Exemplo: -->
                    <div class="mb-3">
                        <x-input-label for="razao_social" value="Razão Social" />
                        <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="Auth::user()->empresa->razao_social ?? ''" required />
                    </div>
                </div>
            @endif

            <div class="flex items-center mt-4">
                <x-primary-button>
                    Salvar Alterações
                </x-primary-button>
                <a href="{{ route('profile.show') }}" class="ms-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
