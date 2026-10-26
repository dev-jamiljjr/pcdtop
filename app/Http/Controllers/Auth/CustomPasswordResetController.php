<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; // Facade para o Password Broker do Laravel
use Illuminate\Validation\ValidationException;
use App\Models\User; // Importa o modelo User, ajuste se o seu modelo de usuário tiver outro nome
use Illuminate\Support\Facades\Log;

class CustomPasswordResetController extends Controller
{
    /**
     * Exibe o formulário de redefinição de senha personalizado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, ?string $token = null)
    {
        // Certifique-se de que a view 'auth.reset-password' está personalizada em português
        // e possui os campos 'email', 'password', 'password_confirmation' e um hidden 'token'.
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Processa a redefinição da senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        Log::info('DIAGNÓSTICO (Custom Reset): Iniciando processo de redefinição de senha customizado.');
        Log::info('DIAGNÓSTICO (Custom Reset): Dados recebidos: email=' . $request->email . ', token=' . $request->token);

        // Validação básica dos campos. A regra 'password' do Laravel Fortify (ou Breeze)
        // já inclui requisitos de complexidade. 'confirmed' verifica se password e password_confirmation são iguais.
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Adicionado 'min:8' como exemplo
        ]);

        Log::info('DIAGNÓSTICO (Custom Reset): Validação de campos de entrada passou.');

        // O Password Broker do Laravel gerencia a validação do token.
        // Ele buscará o token na tabela password_resets.
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                // Se o token for válido, esta callback será executada para atualizar a senha do usuário.
                Log::info('DIAGNÓSTICO (Custom Reset): Token válido. Atualizando senha para usuário: ' . $user->email);

                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();

                Log::info('DIAGNÓSTICO (Custom Reset): Senha atualizada com sucesso para usuário: ' . $user->email);

                // Disparar o evento PasswordReset para notificação ou outros listeners, se necessário
                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        // Lidar com o status do reset (sucesso ou falha)
        if ($status == Password::PASSWORD_RESET) {
            Log::info('DIAGNÓSTICO (Custom Reset): Redefinição de senha concluída com sucesso.');
            return redirect()->route('login')->with('status', __($status));
        }

        Log::error('DIAGNÓSTICO (Custom Reset): Falha na redefinição de senha. Status: ' . $status);
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
