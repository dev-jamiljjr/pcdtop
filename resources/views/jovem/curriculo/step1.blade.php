<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Cadastro de Currículo - Etapa 1: Dados Pessoais</h1>
        <hr class="my-4">

        {{-- Indicador de Etapas --}}
        <div class="d-flex justify-content-between mb-4">
            <div class="text-center flex-fill">
                <span class="badge bg-pcdtop-yellow text-pcdtop-dark-blue fs-6">1. Dados Pessoais</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">2. Endereço</span>
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
            <form action="{{ route('jovem.curriculo.step1.process') }}" method="POST">
                @csrf

                {{-- Campo Data de Nascimento --}}
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">Data de Nascimento <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $data['step1']['data_nascimento'] ?? ($jovem->data_nascimento ? \Carbon\Carbon::parse($jovem->data_nascimento)->format('Y-m-d') : '')) }}" required>
                    @error('data_nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Telefone --}}
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $data['step1']['telefone'] ?? $jovem->telefone) }}" placeholder="(XX) XXXX-XXXX">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Gênero --}}
                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero <span class="text-danger">*</span></label>
                    <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                        <option value="">Selecione...</option>
                        @php
                            $selectedGenero = old('genero', $data['step1']['genero'] ?? $jovem->genero);
                        @endphp
                        <option value="Masculino" {{ $selectedGenero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Feminino" {{ $selectedGenero == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                        <option value="Outro" {{ $selectedGenero == 'Outro' ? 'selected' : '' }}>Outro</option>
                        <option value="Prefiro não dizer" {{ $selectedGenero == 'Prefiro não dizer' ? 'selected' : '' }}>Prefiro não dizer</option>
                    </select>
                    @error('genero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Deficiência --}}
                <div class="mb-3">
                    <label for="deficiencia" class="form-label">Qual(is) sua(s) deficiência(s)?</label>
                    <textarea class="form-control @error('deficiencia') is-invalid @enderror" id="deficiencia" name="deficiencia" rows="3" placeholder="Descreva suas deficiências (ex: visual, auditiva, física, intelectual)">{{ old('deficiencia', $data['step1']['deficiencia'] ?? $jovem->deficiencia) }}</textarea>
                    @error('deficiencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
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
