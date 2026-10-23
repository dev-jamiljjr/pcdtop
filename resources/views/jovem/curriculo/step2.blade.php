<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Cadastro de Currículo - Etapa 2: Endereço</h1>
        <hr class="my-4">

        {{-- Indicador de Etapas --}}
        <div class="d-flex justify-content-between mb-4">
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">1. Dados Pessoais</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-pcdtop-yellow text-pcdtop-dark-blue fs-6">2. Endereço</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">3. Formação e Experiência</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">4. Finalizar</span>
            </div>
        </div>

        {{-- Exibição de mensagens de status (sucesso ou erro) --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm p-4">
            <form action="{{ route('jovem.curriculo.step2.process') }}" method="POST">
                @csrf

                {{-- Campo Endereço --}}
                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control @error('endereco') is-invalid @enderror" id="endereco" name="endereco" value="{{ old('endereco', $data['step2']['endereco'] ?? $jovem->endereco) }}" placeholder="Rua, número, bairro">
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Cidade --}}
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $data['step2']['cidade'] ?? $jovem->cidade) }}" placeholder="Sua cidade">
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Estado --}}
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ old('estado', $data['step2']['estado'] ?? $jovem->estado) }}" placeholder="Seu estado (ex: SP, RJ)">
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('jovem.curriculo.step1') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-pcdtop-primary">Próximo</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
    /* Estilos para o indicador de etapa ativa */
    .bg-pcdtop-yellow {
        background-color: var(--pcdtop-yellow) !important;
    }
    .text-pcdtop-dark-blue {
        color: var(--pcdtop-dark-blue) !important;
    }
    /* CORREÇÃO: Estilo para o botão principal azul com texto branco */
    .btn-pcdtop-primary {
        background-color: var(--pcdtop-blue);
        color: white;
        border-color: var(--pcdtop-blue);
        font-weight: bold;
    }
    .btn-pcdtop-primary:hover {
        background-color: var(--pcdtop-dark-blue); /* Escurece no hover */
        border-color: var(--pcdtop-dark-blue);
        color: white;
    }
</style>
