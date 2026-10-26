<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\PasswordReset; // Importe a classe do evento PasswordReset
use Illuminate\Support\Facades\Log;      // Importe a Facade Log

class LogPasswordReset
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event): void
    {
        $user = $event->user; // O evento PasswordReset tem uma propriedade 'user'

        Log::info('--- DIAGNÓSTICO DE REDEFINIÇÃO DE SENHA ---');
        Log::info('Usuário: ' . $user->email);
        Log::info('Senha (hashed) no momento do evento: ' . $user->password);
        Log::info('Classe do Usuário: ' . get_class($user));
        Log::info('Atributos do Usuário no momento do evento:', $user->getAttributes());
        Log::info('--- FIM DO DIAGNÓSTICO ---');
    }
}
