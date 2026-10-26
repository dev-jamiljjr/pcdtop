<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCD TOP') }}</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])

    </head>
    <body class="d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                {{-- ALTERAÇÃO: Aumentado de col-lg-4 para col-lg-6 para um formulário mais largo em telas grandes --}}
                <div class="col-md-8 col-lg-6">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo-pcdtop.png') }}" alt="Logo PCD TOP" class="img-fluid" style="max-height: 80px;">
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div> {{-- Fechamento da div.row --}}
        </div> {{-- Fechamento da div.container --}}
    </body>
</html>
