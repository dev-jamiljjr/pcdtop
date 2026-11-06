<x-app-layout>
    <div class="container py-4">
        <h1 class="h2 font-bold mb-4">Painel Administrativo do PSE</h1>
        <hr class="my-4">

        <div class="row">
            {{-- NOVOS CARDS PARA USUÁRIOS BLOQUEADOS (COM CORREÇÃO DE ESTILO) --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm"> {{-- Removido text-white e estilo de background --}}
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-fill-lock fs-3 mb-2 text-primary"></i></h5> {{-- Adicionado text-primary ao ícone --}}
                        <p class="card-text h4 font-weight-bold">{{ $jovensBloqueados }}</p>
                        <p class="card-text">Jovens Aguardando Aprovação</p>
                        <a href="{{ route('pse.jovens.bloqueados') }}" class="btn btn-sm btn-outline-primary">Ver Cadastros</a> {{-- Alterado para btn-outline-primary --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm"> {{-- Removido text-white e estilo de background --}}
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-building-lock fs-3 mb-2 text-primary"></i></h5> {{-- Adicionado text-primary ao ícone --}}
                        <p class="card-text h4 font-weight-bold">{{ $empresasBloqueadas }}</p>
                        <p class="card-text">Empresas Aguardando Aprovação</p>
                        <a href="{{ route('pse.empresas.bloqueadas') }}" class="btn btn-sm btn-outline-primary">Ver Cadastros</a> {{-- Alterado para btn-outline-primary --}}
                    </div>
                </div>
            </div>

            {{-- CARDS EXISTENTES (SEM ALTERAÇÃO) --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-fill fs-3 mb-2"></i></h5>
                        <p class="card-text h4 font-weight-bold">{{ $totalJovens }}</p>
                        <p class="card-text">Total de Jovens</p>
                        <a href="{{ route('pse.jovens.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-building-fill fs-3 mb-2"></i></h5>
                        <p class="card-text h4 font-weight-bold">{{ $totalEmpresas }}</p>
                        <p class="card-text">Total de Empresas</p>
                        <a href="{{ route('pse.empresas.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-card-list fs-3 mb-2"></i></h5>
                        <p class="card-text h4 font-weight-bold">{{ $totalVagas }}</p>
                        <p class="card-text">Vagas Cadastradas</p>
                        <a href="{{ route('pse.vagas.index') }}" class="btn btn-sm btn-outline-primary">Ver Vagas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-check-fill fs-3 mb-2"></i></h5>
                        <p class="card-text h4 font-weight-bold">{{ $totalCandidaturas }}</p>
                        <p class="card-text">Candidaturas Registradas</p>
                        <a href="{{ route('pse.candidaturas.index') }}" class="btn btn-sm btn-outline-primary">Ver Candidaturas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
