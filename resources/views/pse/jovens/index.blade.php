<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Jovens Cadastrados (PSE)</h1>
        <hr class="my-4">

        @if ($jovens->isEmpty())
            <div class="alert alert-info">Nenhum jovem cadastrado ainda.</div>
        @else
            <div class="row">
                @foreach ($jovens as $jovemUser)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $jovemUser->name }}</h5>
                                <small>ID: {{ $jovemUser->id }}</small>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>E-mail:</strong> {{ $jovemUser->email }}</p>
                                <p class="card-text"><strong>Tipo de Perfil:</strong> {{ $jovemUser->tipo_perfil }}</p>

                                @if ($jovemUser->jovem)
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Detalhes do Currículo:</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Telefone:</strong> {{ $jovemUser->jovem->telefone ?? 'N/A' }}</li>
                                        <li><strong>Data Nasc.:</strong> {{ $jovemUser->jovem->data_nascimento ? \Carbon\Carbon::parse($jovemUser->jovem->data_nascimento)->format('d/m/Y') : 'N/A' }}</li>
                                        <li><strong>Gênero:</strong> {{ $jovemUser->jovem->genero ?? 'N/A' }}</li>
                                        <li><strong>Endereço:</strong> {{ $jovemUser->jovem->endereco ?? 'N/A' }}</li>
                                        <li><strong>Cidade/Estado:</strong> {{ $jovemUser->jovem->cidade ?? 'N/A' }}/{{ $jovemUser->jovem->estado ?? 'N/A' }}</li>
                                        <li><strong>Deficiência:</strong> {{ $jovemUser->jovem->deficiencia ?? 'N/A' }}</li>
                                        <li><strong>Formação Acadêmica:</strong> <span style="white-space: pre-wrap;">{{ $jovemUser->jovem->formacao_academica ?? 'N/A' }}</span></li>
                                        <li><strong>Experiência Profissional:</strong> <span style="white-space: pre-wrap;">{{ $jovemUser->jovem->experiencia_profissional ?? 'N/A' }}</span></li>
                                        <li><strong>Habilidades:</strong> <span style="white-space: pre-wrap;">{{ $jovemUser->jovem->habilidades ?? 'N/A' }}</span></li>
                                        @if ($jovemUser->jovem->link_portfolio)
                                            <li><strong>Portfólio:</strong> <a href="{{ $jovemUser->jovem->link_portfolio }}" target="_blank" class="text-primary">Ver Portfólio</a></li>
                                        @endif
                                        @if ($jovemUser->jovem->link_linkedin)
                                            <li><strong>LinkedIn:</strong> <a href="{{ $jovemUser->jovem->link_linkedin }}" target="_blank" class="text-primary">Ver LinkedIn</a></li>
                                        @endif
                                        <li><strong>Currículo PDF:</strong>
                                            @if ($jovemUser->jovem->curriculo_path)
                                                <a href="{{ Storage::url($jovemUser->jovem->curriculo_path) }}" target="_blank" class="btn btn-sm btn-info text-white">Visualizar PDF</a>
                                            @else
                                                Não enviado
                                            @endif
                                        </li>
                                    </ul>
                                @else
                                    <p class="text-danger mt-3">Detalhes do perfil jovem não disponíveis (perfil não preenchido).</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $jovens->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
