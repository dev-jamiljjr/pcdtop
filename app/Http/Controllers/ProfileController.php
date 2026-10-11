<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage; // Adicionado para manipulação de arquivos

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('profile.show');
    }

    public function edit(): View
    {
        $user = Auth::user();

        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validar dados comuns do usuário
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        // 2. Atualizar dados do modelo User
        $user->fill($request->only('name', 'email'));

        // 3. Validar e atualizar dados específicos do perfil
        if ($user->tipo_perfil === 'jovem' && $user->jovem) {
            $jovemValidationRules = [
                'data_nascimento' => ['nullable', 'date'],
                'telefone' => ['nullable', 'string', 'max:20'],
                'cidade' => ['nullable', 'string', 'max:255'],
                'estado' => ['nullable', 'string', 'max:2'],
                'escolaridade' => ['nullable', 'string', 'max:255'],
                'deficiencia' => ['nullable', 'string', 'max:255'],
                'area_interesse' => ['nullable', 'string', 'max:255'],
                'experiencia_profissional' => ['nullable', 'string'],
                'curriculo' => ['nullable', 'file', 'mimes:pdf', 'max:2048'], // Regras para o PDF (2MB)
            ];
            $jovemData = $request->validate($jovemValidationRules);

            // Lógica de upload do currículo
            if ($request->hasFile('curriculo')) {
                // Apaga o currículo antigo, se existir
                if ($user->jovem->curriculo_path && Storage::disk('public')->exists($user->jovem->curriculo_path)) {
                    Storage::disk('public')->delete($user->jovem->curriculo_path);
                }
                // Armazena o novo currículo e salva o caminho
                $jovemData['curriculo_path'] = $request->file('curriculo')->store('curriculos', 'public');
            }
            $user->jovem->update($jovemData);

        } elseif ($user->tipo_perfil === 'empresa' && $user->empresa) {
            $empresaData = $request->validate([
                'razao_social' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['required', 'string', 'max:255'],
                'cnpj' => ['required', 'string', 'max:20', Rule::unique('empresas')->ignore($user->empresa->id)],
                'telefone_empresa' => ['nullable', 'string', 'max:20'],
                'email_contato' => ['required', 'string', 'email', 'max:255'],
            ]);
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
