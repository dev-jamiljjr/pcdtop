<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                {{-- Exibe mensagens de erro de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Exibe mensagens de sucesso ou erro da sessão --}}
                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--pcdtop-dark-blue); color: white;">
                        <h4 class="mb-0">Acesso Administrativo</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-4">
                            Para ativar o usuário administrativo, por favor, insira a senha de ativação.
                        </p>

                        <form method="POST" action="{{ route('pse.activate-admin') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="activation_password" class="form-label fw-bold">Senha de Ativação</label>
                                <input id="activation_password" class="form-control" type="password" name="activation_password" required autofocus>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-blue);">
                                    Ativar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
