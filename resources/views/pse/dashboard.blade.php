<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Painel Administrativo do PSE</h1>
        <hr class="my-4">

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-fill fs-3 mb-2"></i></h5>
                        <p class="card-text text-xl font-weight-bold">{{ $totalJovens }}</p>
                        <p class="card-text">Jovens Cadastrados</p>
                        <a href="{{ route('pse.jovens.index') }}" class="btn btn-sm btn-outline-primary">Ver Jovens</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-building-fill fs-3 mb-2"></i></h5>
                        <p class="card-text text-xl font-weight-bold">{{ $totalEmpresas }}</p>
                        <p class="card-text">Empresas Cadastradas</p>
                        <a href="{{ route('pse.empresas.index') }}" class="btn btn-sm btn-outline-primary">Ver Empresas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-card-list fs-3 mb-2"></i></h5>
                        <p class="card-text text-xl font-weight-bold">{{ $totalVagas }}</p>
                        <p class="card-text">Vagas Cadastradas</p>
                        <a href="{{ route('pse.vagas.index') }}" class="btn btn-sm btn-outline-primary">Ver Vagas</a>
                    </div>
                </div>
            </div>
            {{-- Novo Card para Candidaturas --}}
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-check-fill fs-3 mb-2"></i></h5>
                        <p class="card-text text-xl font-weight-bold">{{ $totalCandidaturas }}</p>
                        <p class="card-text">Candidaturas Registradas</p>
                        <a href="{{ route('pse.candidaturas.index') }}" class="btn btn-sm btn-outline-primary">Ver Candidaturas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
