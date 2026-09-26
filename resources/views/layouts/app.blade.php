<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCD TOP') }}</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="d-flex">
            {{-- Sidebar vertical --}}
            <x-sidebar />

            {{-- Área de conteúdo principal com margem à esquerda ajustada para ser igual à largura da sidebar --}}
            <div class="flex-grow-1" style="margin-left: 102px;">
                
                {{-- Conteúdo da página com espaçamento interno (padding) --}}
                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
