<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário não estiver logado ou estiver ativo, ou for um admin PSE, permite o acesso.
        if (!Auth::check() || Auth::user()->isActive() || Auth::user()->tipo_perfil === 'pse') {
            return $next($request);
        }

        // Se o usuário está bloqueado, redireciona para o perfil com uma mensagem de erro.
        if (Auth::user()->isBlocked()) {
            return redirect()->route('profile.show')
                ->with('error', 'Seu acesso a esta funcionalidade está restrito até que seu cadastro seja aprovado pelo administrador.');
        }

        // Por segurança, caso haja um status inesperado, bloqueia o acesso.
        return redirect()->route('profile.show')->with('error', 'Seu perfil possui um status inválido. Contate o suporte.');
    }
}
