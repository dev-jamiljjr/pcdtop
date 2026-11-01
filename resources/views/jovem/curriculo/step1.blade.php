<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 mb-4">Meu Currículo - Etapa 1 de 4</h1>
        <p class="lead mb-4">Preencha seus dados pessoais para começar a construir seu currículo.</p>

        {{-- Barra de Progresso --}}
        <div class="progress mb-4" role="progressbar" aria-label="Etapa 1 de 4" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 25%"></div>
        </div>

        {{-- Exibição de mensagens de status --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <h5 class="alert-heading">Opa! Algo deu errado.</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('jovem.curriculo.step1.process') }}" class="card shadow-sm p-4">
            @csrf
            <h3 class="h4 mb-3">Dados Pessoais</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus />
                    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF (Somente números)</label>
                    <input id="cpf" class="form-control" type="text" name="cpf" value="{{ old('cpf', $jovem->cpf) }}" required placeholder="Ex: 12345678900" />
                    @error('cpf') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                    <input id="data_nascimento" class="form-control" type="date" name="data_nascimento" value="{{ old('data_nascimento', $jovem->data_nascimento) }}" required />
                    @error('data_nascimento') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input id="telefone" class="form-control" type="text" name="telefone" value="{{ old('telefone', $jovem->telefone) }}" placeholder="(99) 99999-9999" />
                    @error('telefone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="genero" class="form-label">Gênero</label>
                    <select id="genero" name="genero" class="form-select" required>
                        <option value="" disabled>Selecione...</option>
                        <option value="Masculino" @selected(old('genero', $jovem->genero) == 'Masculino')>Masculino</option>
                        <option value="Feminino" @selected(old('genero', $jovem->genero) == 'Feminino')>Feminino</option>
                        <option value="Outro" @selected(old('genero', $jovem->genero) == 'Outro')>Outro</option>
                        <option value="Prefiro não dizer" @selected(old('genero', $jovem->genero) == 'Prefiro não dizer')>Prefiro não dizer</option>
                    </select>
                    @error('genero') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="deficiencia" class="form-label">Deficiência (descreva, se aplicável)</label>
                    <textarea id="deficiencia" name="deficiencia" class="form-control" rows="2" placeholder="Ex: Deficiência auditiva leve">{{ old('deficiencia', $jovem->deficiencia) }}</textarea>
                    @error('deficiencia') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-dark-blue); border-color: var(--pcdtop-dark-blue);">
                    Próximo <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
