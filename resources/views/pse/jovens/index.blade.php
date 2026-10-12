<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Jovens Cadastrados (PSE)</h1>
        <hr class="my-4">

        @if ($jovens->isEmpty())
            <div class="alert alert-info">Nenhum jovem cadastrado ainda.</div>
        @else
            <div class="list-group">
                @foreach ($jovens as $jovemUser)
                    <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-lg p-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h5 class="mb-1 font-weight-bold">{{ $jovemUser->name }}</h5>
                            <small class="text-muted">ID: {{ $jovemUser->id }} | E-mail: {{ $jovemUser->email }}</small>
                        </div>
                        <p class="mb-1">Perfil: {{ $jovemUser->tipo_perfil }}</p>
                        @if ($jovemUser->jovem)
                            <p class="mb-1">Telefone: {{ $jovemUser->jovem->telefone ?? 'N/A' }}</p>
                            <p class="mb-1">Cidade/Estado: {{ $jovemUser->jovem->cidade ?? 'N/A' }}/{{ $jovemUser->jovem->estado ?? 'N/A' }}</p>
                            @if ($jovemUser->jovem->curriculo_path)
                                <p class="mb-1">Currículo: <a href="{{ Storage::url($jovemUser->jovem->curriculo_path) }}" target="_blank" class="text-blue-500 hover:underline">Visualizar PDF</a></p>
                            @else
                                <p class="mb-1">Currículo: Não enviado</p>
                            @endif
                        @else
                            <p class="text-danger">Detalhes do perfil jovem não disponíveis.</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $jovens->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
