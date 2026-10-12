<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                {{-- Exibe erros de validação, se houver --}}
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--pcdtop-dark-blue); color: white;">
                        <h4 class="mb-0">Acessar o Sistema</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="height: 60px;">
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label class="form-check-label" for="remember_me">Lembrar-me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-blue);">
                                    Entrar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('register') }}">Não tem uma conta? Registre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
