<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Cadastro de Currículo - Etapa 4: Finalizar</h1>
        <hr class="my-4">

        {{-- Indicador de Etapas --}}
        <div class="d-flex justify-content-between mb-4">
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">1. Dados Pessoais</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">2. Endereço</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-secondary fs-6">3. Formação e Experiência</span>
            </div>
            <div class="text-center flex-fill">
                <span class="badge bg-pcdtop-yellow text-pcdtop-dark-blue fs-6">4. Finalizar</span>
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
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm p-4">
            <form action="{{ route('jovem.curriculo.step4.process') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="mb-3">Upload de Currículo em PDF</h5>
                <p class="text-muted">Faça o upload do seu currículo em formato PDF. (Tamanho máximo: 2MB)</p>

                {{-- Campo para upload de arquivo --}}
                <div class="mb-3">
                    <label for="curriculo_pdf" class="form-label">Selecione seu currículo (PDF)</label>
                    <input class="form-control @error('curriculo_pdf') is-invalid @enderror" type="file" id="curriculo_pdf" name="curriculo_pdf" accept="application/pdf">
                    @error('curriculo_pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Exibição do currículo atual, se houver --}}
                @if ($jovem->curriculo_path)
                    <div class="mb-3">
                        <p>Currículo atual: <a href="{{ Storage::url($jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf-fill me-1"></i>Ver/Baixar Currículo</a></p>
                    </div>
                @else
                    <div class="mb-3">
                        <p class="text-muted">Nenhum currículo em PDF enviado ainda.</p>
                    </div>
                @endif
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('jovem.curriculo.step3') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-pcdtop-primary">Finalizar Cadastro</button>
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
