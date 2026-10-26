<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Log;

class ResetUserPassword implements ResetsUserPasswords
{
    // ADICIONE ESTE CONSTRUTOR
    public function __construct()
    {
        Log::info('DIAGNÓSTICO (Fortify): ResetUserPassword::__construct() foi executado.');
    }

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input)
    {
        Log::info('DIAGNÓSTICO (Fortify): ResetUserPassword::reset() acionada.');
        Log::info('DIAGNÓSTICO (Fortify): Usuário para redefinição: ' . $user->email);

        try {
            Validator::make($input, [
                'password' => ['required', 'string', new Password, 'confirmed'],
            ])->validate();
            Log::info('DIAGNÓSTICO (Fortify): Validação de senha PASSED.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('DIAGNÓSTICO (Fortify): Validação de senha FAILED. Erros: ', $e->errors());
            throw $e;
        } catch (\Throwable $e) {
            Log::error('DIAGNÓSTICO (Fortify): Ocorreu um erro inesperado na validação: ' . $e->getMessage());
            throw $e;
        }

        try {
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
            Log::info('DIAGNÓSTICO (Fortify): Senha hashed e USUÁRIO SALVO com sucesso para: ' . $user->email);
            Log::info('DIAGNÓSTICO (Fortify): Nova senha hashed: ' . substr($user->password, 0, 20) . '...');
        } catch (\Throwable $e) {
            Log::error('DIAGNÓSTICO (Fortify): Erro ao tentar salvar o usuário com a nova senha: ' . $e->getMessage());
            throw $e;
        }
    }
}
