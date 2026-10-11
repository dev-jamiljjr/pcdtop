<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">{{ isset($vaga) ? 'Editar Vaga' : 'Criar Nova Vaga' }}</h1>
        <hr class="my-4">

        <form action="{{ isset($vaga) ? route('vagas.update', $vaga) : route('vagas.store') }}" method="POST">
            @csrf
            @if(isset($vaga))
                @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <x-input-label for="titulo" value="Título da Vaga" />
                    <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo', $vaga->titulo ?? '')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
                </div>
                <div class="col-md-6">
                    <x-input-label for="localizacao" value="Localização" />
                    <x-text-input id="localizacao" class="block mt-1 w-full" type="text" name="localizacao" :value="old('localizacao', $vaga->localizacao ?? '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('localizacao')" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <x-input-label for="tipo_contrato" value="Tipo de Contrato" />
                    <select id="tipo_contrato" name="tipo_contrato" class="form-select mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Selecione...</option>
                        <option value="CLT" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'CLT') ? 'selected' : '' }}>CLT</option>
                        <option value="PJ" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'PJ') ? 'selected' : '' }}>PJ</option>
                        <option value="Estágio" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'Estágio') ? 'selected' : '' }}>Estágio</option>
                        <option value="Temporário" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'Temporário') ? 'selected' : '' }}>Temporário</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('tipo_contrato')" />
                </div>
                <div class="col-md-6">
                    <x-input-label for="salario" value="Salário (Opcional)" />
                    <x-text-input id="salario" class="block mt-1 w-full" type="number" step="0.01" name="salario" :value="old('salario', $vaga->salario ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('salario')" />
                </div>
            </div>

            <div class="mb-3">
                <x-input-label for="descricao" value="Descrição da Vaga" />
                <textarea id="descricao" name="descricao" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5" required>{{ old('descricao', $vaga->descricao ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
            </div>

            <div class="mb-3">
                <x-input-label for="requisitos" value="Requisitos (Opcional)" />
                <textarea id="requisitos" name="requisitos" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('requisitos', $vaga->requisitos ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('requisitos')" />
            </div>

            <div class="mb-3">
                <x-input-label for="beneficios" value="Benefícios (Opcional)" />
                <textarea id="beneficios" name="beneficios" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('beneficios', $vaga->beneficios ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('beneficios')" />
            </div>

            <div class="flex items-center mt-4">
                <x-primary-button>
                    {{ isset($vaga) ? 'Salvar Alterações' : 'Criar Vaga' }}
                </x-primary-button>
                <a href="{{ route('vagas.index') }}" class="ms-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
