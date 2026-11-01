<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCD TOP') }}</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body style="background-color: var(--pcdtop-background);"> {{-- Fundo geral da página --}}
        {{-- Cabeçalho Compacto para Mobile --}}
        <header class="d-lg-none navbar navbar-dark" style="background-color: var(--pcdtop-dark-blue);">
            <div class="container-fluid">
                {{-- Botão Hamburger --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                {{-- Logo do Projeto no Cabeçalho Mobile --}}
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" style="max-height: 40px;">
                </a>
                {{-- Espaçador para centralizar o logo --}}
                <div style="width: 46px;"></div>
            </div>
        </header>

        <div class="d-flex">
            {{-- Sidebar Fixa para Desktop --}}
            <aside class="d-none d-lg-flex flex-column vh-100 position-fixed text-center" style="width: 102px; background-color: var(--pcdtop-dark-blue); color: #fff;">
                <x-sidebar />
            </aside>

            {{-- Offcanvas Sidebar para Mobile --}}
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel" style="width: 102px; background-color: var(--pcdtop-dark-blue);">
                <div class="offcanvas-body d-flex flex-column text-center">
                    <x-sidebar />
                </div>
            </div>

            {{-- Área de conteúdo principal --}}
            <main class="flex-grow-1" style="margin-left: 0;">
                {{-- O fundo branco agora é aplicado aqui para cobrir 100% da altura --}}
                <div class="p-4 bg-white min-vh-100">
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- Estilos para a margem do conteúdo em desktop --}}
        <style>
            @media (min-width: 992px) { /* Breakpoint 'lg' do Bootstrap */
                main.flex-grow-1 {
                    margin-left: 102px !important;
                }
            }
        </style>
        
        {{-- ADICIONADO: Ponto de injeção para scripts das views que usam @push('scripts') --}}
        @stack('scripts') 
    </body>
</html>
