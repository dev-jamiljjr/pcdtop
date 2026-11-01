<x-guest-layout>
    {{-- O layout 'guest.blade.php' já fornece o logo e a estrutura do card. --}}
    {{-- Todo este conteúdo será injetado na variável '$slot', dentro do 'card-body'. --}}

    <div class="text-center mb-3">
        <h4 class="card-title">Verifique seu endereço de e-mail</h4>
    </div>
    <hr class="mt-0 mb-4">

    <p class="mb-4 text-center">
        Obrigado por se cadastrar! Para finalizar, por favor, verifique seu e-mail clicando no link que acabamos de enviar para você.
    </p>

    <p class="text-center text-muted small">
        Se não recebeu o e-mail, clique no botão abaixo e nós enviaremos outro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mt-4 text-center" role="alert">
            Um novo link de verificação foi enviado para o e-mail que você usou no cadastro.
        </div>
    @endif

    <div class="mt-4">
        <div class="d-flex flex-column align-items-center gap-3">
            <form method="POST" action="{{ route('verification.send') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-envelope-check-fill me-2"></i>
                    Reenviar E-mail de Verificação
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-link text-secondary w-100">
                    Sair
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
