<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jovem;
use App\Models\Empresa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Closure;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class,
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value === 'sereficiente@30dejulho.com.br') {
                        $fail('Registro Inválido! Este usuário está reservado!');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo_perfil' => ['required', 'string', 'in:jovem,empresa'],
        ];

        if ($request->tipo_perfil === 'jovem') {
            $rules['cpf'] = ['required', 'string', 'digits:11', 'unique:jovens,cpf'];
        } elseif ($request->tipo_perfil === 'empresa') {
            $rules['cnpj'] = ['required', 'string', 'digits:14', 'unique:empresas,cnpj'];
        }

        $messages = [
            'cpf.unique' => 'Este CPF já está em uso por outra pessoa.',
        ];

        $request->validate($rules, $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_perfil' => $request->tipo_perfil,
        ]);

        if ($request->tipo_perfil === 'jovem') {
            Jovem::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
            ]);
        } elseif ($request->tipo_perfil === 'empresa') {
            Empresa::create([
                'user_id' => $user->id,
                'razao_social' => $request->name,
                'nome_fantasia' => $request->name,
                'cnpj' => $request->cnpj,
                'email_contato' => $request->email,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        $request->session()->flash('status_registro', 'Seja bem-vindo(a) ao PCD TOP! Seu cadastro foi realizado com sucesso! Para garantir a segurança e a privacidade das informações da plataforma, seu acesso será validado pelo Programa Ser Eficiente. Logo você será notificado sobre seu cadastro. Em até 48 horas úteis, receberá uma notificação informando sobre a aprovação e a liberação do seu acesso completo à plataforma. Enquanto isso, pedimos que aguarde. Em breve, você poderá explorar todos os recursos do PCD TOP! Obrigado por fazer parte dessa iniciativa!');

        return redirect()->route('verification.notice');
    }
}
