<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Cadastro de Currículo - Etapa 3: Formação e Experiência</h1>
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
                <span class="badge bg-pcdtop-yellow text-pcdtop-dark-blue fs-6">3. Formação e Experiência</span>
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
            <form action="{{ route('jovem.curriculo.step3.process') }}" method="POST">
                @csrf

                {{-- Campo Formação Acadêmica --}}
                <div class="mb-3">
                    <label for="formacao_academica" class="form-label">Formação Acadêmica</label>
                    <textarea class="form-control @error('formacao_academica') is-invalid @enderror" id="formacao_academica" name="formacao_academica" rows="4" placeholder="Ex: Graduação em Ciência da Computação - Universidade X (2020-2024)">{{ old('formacao_academica', $data['step3']['formacao_academica'] ?? $jovem->formacao_academica) }}</textarea>
                    @error('formacao_academica')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Experiência Profissional --}}
                <div class="mb-3">
                    <label for="experiencia_profissional" class="form-label">Experiência Profissional</label>
                    <textarea class="form-control @error('experiencia_profissional') is-invalid @enderror" id="experiencia_profissional" name="experiencia_profissional" rows="4" placeholder="Ex: Desenvolvedor Júnior na Empresa Y (2024-Presente) - Responsabilidades...">{{ old('experiencia_profissional', $data['step3']['experiencia_profissional'] ?? $jovem->experiencia_profissional) }}</textarea>
                    @error('experiencia_profissional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Habilidades --}}
                <div class="mb-3">
                    <label for="habilidades" class="form-label">Habilidades</label>
                    <textarea class="form-control @error('habilidades') is-invalid @enderror" id="habilidades" name="habilidades" rows="3" placeholder="Ex: PHP, Laravel, MySQL, JavaScript, HTML, CSS, Git, Bootstrap">{{ old('habilidades', $data['step3']['habilidades'] ?? $jovem->habilidades) }}</textarea>
                    @error('habilidades')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Link Portfólio --}}
                <div class="mb-3">
                    <label for="link_portfolio" class="form-label">Link do Portfólio (opcional)</label>
                    <input type="url" class="form-control @error('link_portfolio') is-invalid @enderror" id="link_portfolio" name="link_portfolio" value="{{ old('link_portfolio', $data['step3']['link_portfolio'] ?? $jovem->link_portfolio) }}" placeholder="https://seulink.com/portfolio">
                    @error('link_portfolio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Campo Link LinkedIn --}}
                <div class="mb-3">
                    <label for="link_linkedin" class="form-label">Link do LinkedIn (opcional)</label>
                    <input type="url" class="form-control @error('link_linkedin') is-invalid @enderror" id="link_linkedin" name="link_linkedin" value="{{ old('link_linkedin', $data['step3']['link_linkedin'] ?? $jovem->link_linkedin) }}" placeholder="https://linkedin.com/in/seuperfil">
                    @error('link_linkedin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('jovem.curriculo.step2') }}" class="btn btn-secondary">Voltar</a>
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
