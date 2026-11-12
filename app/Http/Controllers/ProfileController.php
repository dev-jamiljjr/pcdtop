<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa.contatos');
        }
        return view('profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = Auth::user();

        if ($user->tipo_perfil === 'jovem') {
            $user->load('jovem');
        } elseif ($user->tipo_perfil === 'empresa') {
            $user->load('empresa.contatos');
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

        if ($user->tipo_perfil !== 'empresa') {
            $user->email = $request->input('email');
        }
        $user->name = $request->input('name');

        // 2. Validar e atualizar dados específicos do perfil
        if ($user->tipo_perfil === 'jovem' && $user->jovem) {
            // Fluxo do jovem mantido inalterado
        } elseif ($user->tipo_perfil === 'empresa' && $user->empresa) {
            $empresaData = $request->validate([
                'razao_social' => ['required', 'string', 'max:255'],
                'nome_fantasia' => ['required', 'string', 'max:255'],
                'telefone' => ['nullable', 'string', 'max:20'],
                'website' => ['nullable', 'url', 'max:255'],
                'endereco' => ['nullable', 'string', 'max:255'],
                'bairro' => ['nullable', 'string', 'max:255'],
                'cidade' => ['nullable', 'string', 'max:255'],
                'estado' => ['nullable', 'string', 'max:2'],
                'cep' => ['nullable', 'string', 'max:10'],
            ]);

            // Preserva estritamente os valores originais de CNPJ e E-mail da Empresa
            $empresaData['cnpj'] = $user->empresa->cnpj;
            $empresaData['email_contato'] = $user->empresa->email_contato;

            if (!empty($empresaData['cep'])) {
                $empresaData['cep'] = preg_replace('/\D/', '', $empresaData['cep']);
            }

            $user->empresa->update($empresaData);

            // Validar contatos sem restrições de unicidade desnecessárias
            $request->validate([
                'contatos.*.nome' => ['nullable', 'string', 'max:255'],
                'contatos.*.cargo' => ['nullable', 'string', 'max:255'],
                'contatos.*.cpf' => ['nullable', 'string', 'max:20'],
                'contatos.*.telefone' => ['nullable', 'string', 'max:20'],
                'contatos.*.email' => ['nullable', 'email', 'max:255'],
            ]);

            foreach ($request->input('contatos', []) as $contatoData) {
                $contatoId = $contatoData['id'] ?? null;
                $nome = trim($contatoData['nome'] ?? '');

                // Se o nome não foi preenchido, o contato é considerado inexistente ou removido
                if (empty($nome)) {
                    if (!empty($contatoId)) {
                        $user->empresa->contatos()->where('id', $contatoId)->delete();
                    }
                    continue;
                }

                // Sanitização e formatação dos campos de contato
                $dadosParaSalvar = [
                    'nome' => $nome,
                    'cargo' => !empty($contatoData['cargo']) ? trim($contatoData['cargo']) : null,
                    'cpf' => !empty($contatoData['cpf']) ? preg_replace('/\D/', '', $contatoData['cpf']) : null,
                    'telefone' => !empty($contatoData['telefone']) ? trim($contatoData['telefone']) : null,
                    'email' => !empty($contatoData['email']) ? trim($contatoData['email']) : null,
                ];

                if (!empty($contatoId)) {
                    $user->empresa->contatos()->where('id', $contatoId)->update($dadosParaSalvar);
                } else {
                    $user->empresa->contatos()->create($dadosParaSalvar);
                }
            }
        }

        // 3. Salvar User se alterado
        if ($user->isDirty('name') || $user->isDirty('email')) {
            $user->save();
        }

        return redirect()->route('profile.show')->with('status', 'Perfil atualizado com sucesso!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('home')->with('status', 'profile-deleted');
    }
}
