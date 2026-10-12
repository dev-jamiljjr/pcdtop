<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <x-validation-errors class="mb-4" />

                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--pcdtop-dark-blue); color: white;">
                        <h4 class="mb-0">Redefinir Senha</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-4">
                            Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.
                        </p>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-blue);">
                                    Enviar Link de Redefinição
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('login') }}">Voltar para o Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
