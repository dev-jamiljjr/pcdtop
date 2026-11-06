<x-app-layout>
    <div class="container py-4">
        <a href="{{ route('pse.dashboard') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Voltar para o Painel
        </a>

        <h1 class="h2 mb-4">Empresas Aguardando Aprovação</h1>
        <p>Lista de empresas recém-cadastradas que aguardam aprovação para ter suas vagas publicadas e acessar todas as funcionalidades da plataforma.</p>
        <hr class="my-4">

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($empresas->isEmpty())
            <div class="alert alert-info mt-4" role="alert">
                Nenhuma empresa aguardando aprovação no momento.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome Fantasia / Razão Social</th>
                            <th>E-mail de Contato</th>
                            <th>Data de Cadastro</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $usuario)
                            <tr>
                                <td>{{ $usuario->empresa->nome_fantasia ?? $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <form action="{{ route('pse.users.toggle-status', $usuario->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Desbloquear e ativar usuário">
                                            <i class="bi bi-check-circle me-1"></i> Desbloquear
                                        </button>
                                    </form>
                                    <a href="{{ route('pse.empresas.show', ['empresa' => $usuario->empresa->id]) }}" class="btn btn-sm btn-outline-secondary">Ver Perfil Completo</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $empresas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
