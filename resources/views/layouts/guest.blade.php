  GNU nano 8.7.1                            resources/views/layouts/guest.blade.php *
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCD TOP') }}</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js']) // ALTERE AQUI

    </head>
    <body class="d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    {{-- O logo será inserido aqui --}}
                    <div class="text-center mb-4">
                        {{-- <img src="..." alt="Logo PCD TOP"> --}}
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
