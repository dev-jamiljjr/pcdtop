<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Criar Nova Vaga</h1>
        <hr class="my-4">

        {{-- Inclui o formulário real, passando vaga como null para criação --}}
        @include('vagas._form', ['vaga' => null])
    </div>
</x-app-layout>
