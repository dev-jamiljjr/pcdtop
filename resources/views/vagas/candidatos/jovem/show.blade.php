<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('vagas.candidatos.index', $vaga->id) }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para Candidatos da Vaga
        </a>

        <h1 class="h2 mb-4">Perfil do Candidato: {{ $jovem->user->name }}</h1>
        <h2 class="h4 text-muted mb-4">Para a vaga: "{{ $vaga->titulo }}"</h2>
        <hr class="my-4">

        <div class="card shadow-sm p-4 mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="fw-bold">Informações Pessoais</h5>
                    <p><strong>Nome:</strong> {{ $jovem->user->name }}</p>
                    <p><strong>E-mail:</strong> {{ $jovem->user->email }}</p>
                    <p><strong>Telefone:</strong> {{ $jovem->telefone ?? 'Não informado' }}</p>
                    <p><strong>Data de Nasc.:</strong> {{ $jovem->data_nascimento ? \Carbon\Carbon::parse($jovem->data_nascimento)->format('d/m/Y') : 'Não informado' }}</p>
                    <p><strong>Gênero:</strong> {{ $jovem->genero ?? 'Não informado' }}</p>
                    <p><strong>Endereço:</strong> {{ $jovem->endereco ?? 'Não informado' }}</p>
                    <p><strong>Cidade/Estado:</strong> {{ $jovem->cidade ?? 'Não informado' }}/{{ $jovem->estado ?? 'Não informado' }}</p>
                    <p><strong>Deficiência:</strong> {{ $jovem->deficiencia ?? 'Não informado' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="fw-bold">Informações Profissionais</h5>
                    <p><strong>Formação Acadêmica:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->formacao_academica ?? 'Não informado' }}</p>
                    <p><strong>Experiência Profissional:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->experiencia_profissional ?? 'Não informado' }}</p>
                    <p><strong>Habilidades:</strong></p>
                    <p style="white-space: pre-wrap;">{{ $jovem->habilidades ?? 'Não informado' }}</p>
                    @if ($jovem->link_portfolio)
                        <p><strong>Portfólio:</strong> <a href="{{ $jovem->link_portfolio }}" target="_blank" class="text-primary">Ver Portfólio</a></p>
                    @endif
                    @if ($jovem->link_linkedin)
                        <p><strong>LinkedIn:</strong> <a href="{{ $jovem->link_linkedin }}" target="_blank" class="text-primary">Ver LinkedIn</a></p>
                    @endif
                    <p class="mt-3"><strong>Currículo PDF:</strong>
                        @if ($jovem->curriculo_path)
                            {{-- <<< ALTERAÇÃO AQUI: Aponta para a nova rota de visualização de PDF >>> --}}
                            <a href="{{ route('vagas.candidatos.jovem.viewCurriculoPdf', ['vaga' => $vaga->id, 'jovem' => $jovem->id]) }}" target="_blank" class="btn btn-sm btn-info text-white">Visualizar Currículo</a>
                        @else
                            Não enviado
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
