<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Meu Currículo - Etapa 2 de 4</h1>
        <p class="lead mb-4">Informe seu endereço para que as empresas possam encontrar você.</p>

        {{-- Barra de Progresso --}}
        <div class="progress mb-4" role="progressbar" aria-label="Etapa 2 de 4" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 50%"></div>
        </div>

        <form method="POST" action="{{ route('jovem.curriculo.step2.process') }}" class="card shadow-sm p-4">
            @csrf
            <h3 class="h4 mb-3">Endereço</h3>
            <div class="row g-3">
                <div class="col-12">
                    <label for="endereco" class="form-label">Endereço (Rua, Número)</label>
                    <input id="endereco" class="form-control" type="text" name="endereco" value="{{ old('endereco', $jovem->endereco) }}" />
                </div>
                <div class="col-md-6">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input id="bairro" class="form-control" type="text" name="bairro" value="{{ old('bairro', $jovem->bairro) }}" />
                </div>
                <div class="col-md-6">
                    <label for="cep" class="form-label">CEP</label>
                    <input id="cep" class="form-control" type="text" name="cep" value="{{ old('cep', $jovem->cep) }}" />
                </div>
                <div class="col-md-6">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input id="cidade" class="form-control" type="text" name="cidade" value="{{ old('cidade', $jovem->cidade) }}" />
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <input id="estado" class="form-control" type="text" name="estado" value="{{ old('estado', $jovem->estado) }}" />
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('jovem.curriculo.step1') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Voltar</a>
                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    Próximo <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
