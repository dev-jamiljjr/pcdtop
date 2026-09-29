<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jovem;
use App\Models\Empresa;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo_perfil' => ['required', 'string', 'in:jovem,empresa'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_perfil' => $request->tipo_perfil,
        ]);

        if ($request->tipo_perfil === 'jovem') {
            Jovem::create(['user_id' => $user->id]);
        } elseif ($request->tipo_perfil === 'empresa') {
            Empresa::create([
                'user_id' => $user->id,
                'razao_social' => $request->name,
                'nome_fantasia' => $request->name,
                // CORREÇÃO: Gera um CNPJ único para cada novo cadastro de empresa
                'cnpj' => '00.000.000/0000-' . uniqid(),
                'email_contato' => $request->email,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
