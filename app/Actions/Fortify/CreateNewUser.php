<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str; // Importa o helper de String

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valida e cria um novo usuário.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        // CONVERTE O E-MAIL PARA MINÚSCULAS ANTES DE TUDO
        $input['email'] = isset($input['email']) ? Str::lower($input['email']) : null;

        // VALIDA OS DADOS JÁ COM O E-MAIL CONVERTIDO
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        // CRIA O USUÁRIO COM O E-MAIL JÁ EM MINÚSCULAS
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
