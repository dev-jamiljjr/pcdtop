<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #004269; color: white;">
                        {{ __('Redefinir Senha') }}
                    </div>

                    <div class="card-body p-4">

                        <!-- Exibe mensagens de status (Ex: senha redefinida com sucesso) -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- CORREÇÃO: Bloco para exibir erros de validação -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Token de Redefinição de Senha (Obrigatório e Oculto) -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Campo de E-mail (Obrigatório e Pré-preenchido) -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $email) }}" required autofocus readonly>
                            </div>

                            <!-- Campo Nova Senha -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Nova Senha') }}</label>
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                            </div>

                            <!-- Campo Confirmar Nova Senha -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirmar Nova Senha') }}</label>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #004269; border-color: #004269;">
                                    {{ __('Redefinir Senha') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
