<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage; // Adicionado para manipulação de arquivos
use Illuminate\Http\RedirectResponse; // Adicionado para os retornos de redirecionamento

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem'); // Garante que os dados do jovem sejam carregados
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa'); // Garante que os dados da empresa sejam carregados
        }
        return view('profile.show', compact('user')); // Passa o usuário carregado para a view
    }

    public function edit(): View
    {
        $user = Auth::user();

        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem'); // Carrega os dados do jovem associado
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa'); // Carrega os dados da empresa associada
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
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
                'endereco' => ['nullable', 'string', 'max:255'], // Campo adicionado
                'cidade' => ['nullable', 'string', 'max:255'],
                'estado' => ['nullable', 'string', 'max:2'],
                'genero' => ['nullable', 'string', 'max:50'], // Campo adicionado
                'deficiencia' => ['nullable', 'string'], // Tipo 'text' no BD
                'formacao_academica' => ['nullable', 'string'], // Campo adicionado (longText)
                'experiencia_profissional' => ['nullable', 'string'], // Tipo 'longText' no BD
                'habilidades' => ['nullable', 'string'], // Campo adicionado (text)
                'link_portfolio' => ['nullable', 'url', 'max:255'], // Campo adicionado, valida como URL
                'link_linkedin' => ['nullable', 'url', 'max:255'], // Campo adicionado, valida como URL
                'curriculo' => ['nullable', 'file', 'mimes:pdf', 'max:2048'], // Regras para o PDF (2MB)
            ];
            // Os campos 'escolaridade' e 'area_interesse' foram removidos da migration e, portanto, do fillable
            // e não devem mais ser validados aqui.

            $jovemData = $request->validate($jovemValidationRules);

            // Lógica de upload do currículo em PDF
            if ($request->hasFile('curriculo')) {
                // Apaga o currículo antigo, se existir
                if ($user->jovem->curriculo_path && Storage::disk('public')->exists($user->jovem->curriculo_path)) {
                    Storage::disk('public')->delete($user->jovem->curriculo_path);
                }
                // Armazena o novo currículo e salva o caminho
                $jovemData['curriculo_path'] = $request->file('curriculo')->store('curriculos', 'public');
            } else {
                // Se nenhum novo arquivo foi enviado, remove 'curriculo' da array para não tentar salvar
                // o objeto File no banco de dados. O curriculo_path existente será mantido.
                unset($jovemData['curriculo']);
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
            // Ajuste para o campo de telefone da empresa, se houver diferença de nome
            $empresaData['telefone'] = $empresaData['telefone_empresa'] ?? null;
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
