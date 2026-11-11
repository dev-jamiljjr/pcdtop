<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Meu Currículo - Etapa 3 de 4</h1>
        <p class="lead mb-4">Descreva sua formação, experiências e habilidades.</p>

        {{-- Barra de Progresso --}}
        <div class="progress mb-4" role="progressbar" aria-label="Etapa 3 de 4" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 75%"></div>
        </div>

        <form method="POST" action="{{ route('jovem.curriculo.step3.process') }}" class="card shadow-sm p-4">
            @csrf
            <h3 class="h4 mb-3">Qualificação Profissional</h3>
            <div class="row g-3">
                <div class="col-12">
                    <label for="formacao" class="form-label">Formação</label>
                    <textarea id="formacao" name="formacao_academica" class="form-control" rows="4">{{ old('formacao_academica', $jovem->formacao_academica) }}</textarea>
                </div>
                <div class="col-12">
                    <label for="experiencia_profissional" class="form-label">Experiência Profissional</label>
                    <textarea id="experiencia_profissional" name="experiencia_profissional" class="form-control" rows="4">{{ old('experiencia_profissional', $jovem->experiencia_profissional) }}</textarea>
                </div>
                <div class="col-12">
                    <label for="habilidades" class="form-label">Habilidades</label>
                    <textarea id="habilidades" name="habilidades" class="form-control" rows="3">{{ old('habilidades', $jovem->habilidades) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="link_portfolio" class="form-label">Link Portfólio (opcional)</label>
                    <input id="link_portfolio" class="form-control" type="url" name="link_portfolio" value="{{ old('link_portfolio', $jovem->link_portfolio) }}" />
                </div>
                <div class="col-md-6">
                    <label for="link_linkedin" class="form-label">Link LinkedIn (opcional)</label>
                    <input id="link_linkedin" class="form-control" type="url" name="link_linkedin" value="{{ old('link_linkedin', $jovem->link_linkedin) }}" />
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" name="action" value="back" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Voltar</button>
                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    Próximo <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
