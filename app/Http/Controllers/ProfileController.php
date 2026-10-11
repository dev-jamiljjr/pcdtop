<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\User; // Importa o modelo User

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('profile.show');
    }

    public function edit(): View
    {
        $user = Auth::user();

        // Carrega o relacionamento 'jovem' ou 'empresa' condicionalmente
        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa');
        }

        return view('profile.edit', compact('user')); // Passa o usuário (com perfil carregado) para a view
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validar dados comuns
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        // 2. Atualizar dados do modelo User
        $user->fill($request->only('name', 'email'));

        // 3. Validar e atualizar dados específicos do perfil
        if ($user->tipo_perfil === 'jovem' && $user->jovem) {
            $jovemData = $request->validate([
                'data_nascimento' => ['nullable', 'date'],
                'telefone' => ['nullable', 'string', 'max:20'],
                'cidade' => ['nullable', 'string', 'max:255'],
                'estado' => ['nullable', 'string', 'max:2'],
                'escolaridade' => ['nullable', 'string', 'max:255'],
                'deficiencia' => ['nullable', 'string', 'max:255'],
                'area_interesse' => ['nullable', 'string', 'max:255'],
                'experiencia_profissional' => ['nullable', 'string'],
            ]);
            $user->jovem->update($jovemData);

        } elseif ($user->tipo_perfil === 'empresa' && $user->empresa) {
            $empresaData = $request->validate([
                'razao_social' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['required', 'string', 'max:255'],
                'cnpj' => ['required', 'string', 'max:20', Rule::unique('empresas')->ignore($user->empresa->id)],
                'telefone_empresa' => ['nullable', 'string', 'max:20'],
                'email_contato' => ['required', 'string', 'email', 'max:255'],
            ]);
            // Renomeia 'telefone_empresa' para 'telefone' para corresponder ao modelo
            $empresaData['telefone'] = $empresaData['telefone_empresa'];
            unset($empresaData['telefone_empresa']);

            $user->empresa->update($empresaData);
        }

        // 4. Salvar o modelo User (apenas se houver alterações nos campos dele)
        if ($user->isDirty('name') || $user->isDirty('email')) {
            $user->save();
        }

        // 5. Redirecionar com mensagem de sucesso
        return redirect()->route('profile.show')->with('status', 'Perfil atualizado com sucesso!');
    }
}
