<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <!-- Bloco para exibir erros de validação (substitui x-validation-errors) -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--pcdtop-dark-blue); color: white;">
                        <h4 class="mb-0">Criar Nova Conta</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="tipo_perfil" class="form-label">Tipo de Perfil</label>
                                <select id="tipo_perfil" name="tipo_perfil" class="form-select" required onchange="toggleFields()">
                                    <option value="" disabled {{ old('tipo_perfil') ? '' : 'selected' }}>Selecione uma opção</option>
                                    <option value="jovem" {{ old('tipo_perfil') == 'jovem' ? 'selected' : '' }}>Jovem (Procuro uma oportunidade)</option>
                                    <option value="empresa" {{ old('tipo_perfil') == 'empresa' ? 'selected' : '' }}>Empresa (Quero contratar)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label" id="name_label">Nome Completo</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                            </div>

                            <!-- Campo CPF (Inicialmente oculto, visível para Jovem) -->
                            <div class="mb-3" id="cpf_field" style="display: none;">
                                <label for="cpf" class="form-label">CPF</label>
                                <input id="cpf" class="form-control" type="text" name="cpf" value="{{ old('cpf') }}" pattern="\d{11}" title="O CPF deve conter 11 dígitos numéricos." placeholder="Apenas números">
                            </div>

                            <!-- Campo CNPJ (Inicialmente oculto, visível para Empresa) -->
                            <div class="mb-3" id="cnpj_field" style="display: none;">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input id="cnpj" class="form-control" type="text" name="cnpj" value="{{ old('cnpj') }}" pattern="\d{14}" title="O CNPJ deve conter 14 dígitos numéricos." placeholder="Apenas números">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
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

    {{-- Script para alternar campos com base no tipo de perfil --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleFields(); // Garante que os campos corretos são exibidos ao carregar a página (útil para old('tipo_perfil'))
        });

        function toggleFields() {
            const tipoPerfil = document.getElementById('tipo_perfil').value;
            const nameLabel = document.getElementById('name_label');
            const nameInput = document.getElementById('name');
            const cpfField = document.getElementById('cpf_field');
            const cnpjField = document.getElementById('cnpj_field');
            const cpfInput = document.getElementById('cpf');
            const cnpjInput = document.getElementById('cnpj');

            // Resetar campos e seus estados de required
            nameInput.removeAttribute('placeholder');
            cpfField.style.display = 'none';
            cpfInput.removeAttribute('required');
            cnpjField.style.display = 'none';
            cnpjInput.removeAttribute('required');

            if (tipoPerfil === 'jovem') {
                nameLabel.textContent = 'Nome Completo';
                nameInput.setAttribute('placeholder', 'Seu nome completo');
                cpfField.style.display = 'block';
                cpfInput.setAttribute('required', 'required');
            } else if (tipoPerfil === 'empresa') {
                nameLabel.textContent = 'Razão Social';
                nameInput.setAttribute('placeholder', 'Nome completo da sua empresa');
                cnpjField.style.display = 'block';
                cnpjInput.setAttribute('required', 'required');
            }
        }
    </script>
    @endpush
</x-app-layout>
