<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // ALTERAÇÃO: Redireciona para a rota 'home' se o usuário já estiver verificado.
            return redirect()->intended(route('home', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        // Esta linha já estava correta, retorna para a página anterior com uma mensagem.
        return back()->with('status', 'verification-link-sent');
    }
}
