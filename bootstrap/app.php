<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Providers\FortifyServiceProvider; // Importe o FortifyServiceProvider

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registre seus middlewares de rota aqui
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'is.jovem' => \App\Http\Middleware\CheckJovemProfile::class,
            // ... outros aliases existentes ...
        ]);

        // Redireciona usuários autenticados para a rota raiz '/'
        // Isso é importante após o login e também após a verificação do e-mail.
        $middleware->redirectUsersTo('/'); // <--- LINHA ADICIONADA AQUI

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })
    // REGISTRAR O FORTIFY SERVICE PROVIDER AQUI
    ->withProviders([
        FortifyServiceProvider::class,
    ])
    ->create();

