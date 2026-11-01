<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa.contatos'); // Carrega a empresa e seus contatos
        }
        return view('profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = Auth::user();

        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa.contatos'); // Carrega a empresa e seus contatos
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
            // ... (código de atualização do jovem permanece o mesmo) ...

        } elseif ($user->tipo_perfil === 'empresa' && $user->empresa) {
            // Validar e atualizar dados da Empresa
            $empresaData = $request->validate([
                'razao_social' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['required', 'string', 'max:255'],
                'cnpj' => ['required', 'string', 'max:20', Rule::unique('empresas')->ignore($user->empresa->id)],
                'telefone' => ['nullable', 'string', 'max:20'],
                'email_contato' => ['required', 'string', 'email', 'max:255'],
                'website' => ['nullable', 'url', 'max:255'],
                'endereco' => ['nullable', 'string', 'max:255'],
                'bairro' => ['nullable', 'string', 'max:255'],
                'cidade' => ['nullable', 'string', 'max:255'],
                'estado' => ['nullable', 'string', 'max:2'],
                'cep' => ['nullable', 'string', 'max:10'],
            ]);
            $user->empresa->update($empresaData);

            // Validar e atualizar Contatos da Empresa
            $request->validate([
                'contatos.*.nome' => ['required_with:contatos.*.email', 'string', 'max:255'],
                'contatos.*.cargo' => ['nullable', 'string', 'max:255'],
                'contatos.*.cpf' => ['required_with:contatos.*.email', 'string', 'max:14', 'distinct'],
                'contatos.*.telefone' => ['nullable', 'string', 'max:20'],
                'contatos.*.email' => ['nullable', 'email', 'max:255', 'distinct'],
            ]);
            
            foreach ($request->input('contatos', []) as $contatoData) {
                // Remove campos vazios para não tentar salvar um contato em branco
                $contatoData = array_filter($contatoData);

                if (empty($contatoData['nome']) && empty($contatoData['email'])) {
                    // Se o contato ID existe mas os dados estão vazios, apaga o registro.
                    if (!empty($contatoData['id'])) {
                         $user->empresa->contatos()->find($contatoData['id'])->delete();
                    }
                    continue; // Pula para o próximo contato se nome e email estiverem vazios
                }

                $user->empresa->contatos()->updateOrCreate(
                    ['id' => Arr::pull($contatoData, 'id')], // Procura por ID ou cria um novo
                    $contatoData // Dados para atualizar ou criar
                );
            }
        }

        // 4. Salvar o modelo User (apenas se houver alterações nos campos dele)
        if ($user->isDirty('name') || $user->isDirty('email')) {
            $user->save();
        }

        // 5. Redirecionar com mensagem de sucesso
        return redirect()->route('profile.show')->with('status', 'Perfil atualizado com sucesso!');
    }
}
