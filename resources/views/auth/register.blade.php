<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <x-validation-errors class="mb-4" />

                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--pcdtop-dark-blue); color: white;">
                        <h4 class="mb-0">Criar Nova Conta</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username">
                            </div>
                            
                            <div class="mb-3">
                                <label for="tipo_perfil" class="form-label">Tipo de Perfil</label>
                                <select id="tipo_perfil" name="tipo_perfil" class="form-select" required>
                                    <option value="" disabled selected>Selecione uma opção</option>
                                    <option value="jovem" {{ old('tipo_perfil') == 'jovem' ? 'selected' : '' }}>Jovem (Procuro uma oportunidade)</option>
                                    <option value="empresa" {{ old('tipo_perfil') == 'empresa' ? 'selected' : '' }}>Empresa (Quero contratar)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: var(--pcdtop-blue);">
                                    Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('login') }}">Já tem uma conta? Acesse aqui</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
