{{-- Esta é uma partial view que contém apenas o formulário de vagas --}}
{{-- Ela não deve ser acessada diretamente e não inclui <x-app-layout> --}}
{{-- A variável $vaga pode ser passada como null para criação --}}

<form action="{{ isset($vaga) ? route('vagas.update', $vaga) : route('vagas.store') }}" method="POST">
    @csrf
    @if(isset($vaga))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="titulo" class="form-label">Título da Vaga</label>
            <input id="titulo" class="form-control" type="text" name="titulo" value="{{ old('titulo', $vaga->titulo ?? '') }}" required autofocus>
            @error('titulo')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="localizacao" class="form-label">Localização</label>
            <input id="localizacao" class="form-control" type="text" name="localizacao" value="{{ old('localizacao', $vaga->localizacao ?? '') }}" required>
            @error('localizacao')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
            <select id="tipo_contrato" name="tipo_contrato" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="CLT" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'CLT') ? 'selected' : '' }}>CLT</option>
                <option value="PJ" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'PJ') ? 'selected' : '' }}>PJ</option>
                <option value="Estágio" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'Estágio') ? 'selected' : '' }}>Estágio</option>
                <option value="Temporário" {{ (old('tipo_contrato', $vaga->tipo_contrato ?? '') == 'Temporário') ? 'selected' : '' }}>Temporário</option>
            </select>
            @error('tipo_contrato')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="salario" class="form-label">Salário (Opcional)</label>
            <input id="salario" class="form-control" type="number" step="0.01" name="salario" value="{{ old('salario', $vaga->salario ?? '') }}">
            @error('salario')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição da Vaga</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="5" required>{{ old('descricao', $vaga->descricao ?? '') }}</textarea>
        @error('descricao')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="requisitos" class="form-label">Requisitos (Opcional)</label>
        <textarea id="requisitos" name="requisitos" class="form-control" rows="3">{{ old('requisitos', $vaga->requisitos ?? '') }}</textarea>
        @error('requisitos')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="beneficios" class="form-label">Benefícios (Opcional)</label>
        <textarea id="beneficios" name="beneficios" class="form-control" rows="3">{{ old('beneficios', $vaga->beneficios ?? '') }}</textarea>
        @error('beneficios')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($vaga) ? 'Salvar Alterações' : 'Criar Vaga' }}
        </button>
        <a href="{{ route('vagas.index') }}" class="btn btn-secondary ms-3">
            Cancelar
        </a>
    </div>
</form>
