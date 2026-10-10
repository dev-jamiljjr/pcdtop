<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Exibe a página de perfil do usuário logado.
     */
    public function show(): View
    {
        return view('profile.show');
    }

    /**
     * Exibe o formulário para editar o perfil do usuário logado.
     */
    public function edit(): View
    {
        // O usuário e seu perfil já estão disponíveis via Auth::user()
        // e os relacionamentos definidos no modelo User (jovem(), empresa()).
        return view('profile.edit');
    }

    /**
     * Atualiza as informações do perfil do usuário logado.
     */
    public function update(Request $request)
    {
        // Lógica de validação e atualização será adicionada aqui.
        // Esta função será o destino do formulário de edição.
        return redirect()->route('profile.show')->with('status', 'Perfil atualizado com sucesso!');
    }
}
