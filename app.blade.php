<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCD TOP') }}</title>

        {{-- Diretiva do Vite para carregar os assets compilados --}}
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="d-flex">
        {{-- O componente da sidebar será inserido aqui na próxima etapa --}}
        {{-- <x-sidebar /> --}}

        <div class="flex-grow-1">
            {{-- O componente do header será inserido aqui na próxima etapa --}}
            {{-- <x-header /> --}}

            {{-- Conteúdo principal da página --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
