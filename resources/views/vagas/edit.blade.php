<x-app-layout>
    <div class="container py-4">
        <h1 class="text-2xl font-bold mb-4">Editar Vaga</h1>
        <hr class="my-4">

        {{-- Inclui o formulário real, passando a vaga existente para edição --}}
        @include('vagas._form', ['vaga' => $vaga])
    </div>
</x-app-layout>
