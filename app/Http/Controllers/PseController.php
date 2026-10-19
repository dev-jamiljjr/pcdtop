<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PseController extends Controller
{
    /**
     * Exibe o dashboard administrativo do PSE.
     */
    public function dashboard()
    {
        $totalJovens = User::where('tipo_perfil', 'jovem')->count();
        $totalEmpresas = User::where('tipo_perfil', 'empresa')->count();
        $totalVagas = Vaga::count();

        return view('pse.dashboard', compact('totalJovens', 'totalEmpresas', 'totalVagas'));
    }

    /**
     * Lista todos os jovens cadastrados, ordenados alfabeticamente e carrega os detalhes do perfil jovem.
     */
    public function listJovens()
    {
        // Carrega os usuários do tipo 'jovem' e eagerness carrega o relacionamento 'jovem'
        $jovens = User::where('tipo_perfil', 'jovem')
                      ->with('jovem') // Eager load the 'jovem' relationship
                      ->orderBy('name', 'asc')
                      ->paginate(10);
        return view('pse.jovens.index', compact('jovens'));
    }

    /**
     * Lista todas as empresas cadastradas, ordenadas alfabeticamente.
     */
    public function listEmpresas()
    {
        $empresas = User::where('tipo_perfil', 'empresa')->orderBy('name', 'asc')->paginate(10);
        return view('pse.empresas.index', compact('empresas'));
    }

    /**
     * Lista todas as vagas cadastradas, ordenadas alfabeticamente pelo título.
     */
    public function listVagas()
    {
        $vagas = Vaga::orderBy('titulo', 'asc')->paginate(10);
        return view('pse.vagas.index', compact('vagas'));
    }

    /**
     * Exibe o formulário para inserir a senha de ativação do administrador.
     */
    public function showAdminActivationForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('pse.activate-admin-form');
    }

    /**
     * Processa a ativação do usuário administrativo do PSE.
     */
    public function activateAdmin(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $request->validate([
            'activation_password' => ['required', 'string'],
        ]);

        $inputPassword = $request->input('activation_password');
        $storedHash = config('app.pse_activation_key_hash');

        if (empty($storedHash)) {
            Log::warning('PSE_ACTIVATION_KEY_HASH não configurado no .env!');
            return back()->with('error', 'Erro de configuração: Chave de ativação não encontrada.');
        }

        if (!Hash::check($inputPassword, $storedHash)) {
            Log::warning('Tentativa de ativação de administrador com senha incorreta: ' . $inputPassword);
            return back()->with('error', 'Senha de ativação incorreta.');
        }

        $adminEmail = 'sereficiente@30dejulho.com.br';
        $initialAdminPassword = 'pse@CEB1947';

        $user = User::where('email', $adminEmail)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'PSE Admin',
                'email' => $adminEmail,
                'password' => Hash::make($initialAdminPassword),
                'tipo_perfil' => 'pse',
            ]);
            Log::info("Usuário administrativo PSE '{$adminEmail}' criado com sucesso.");
            Auth::login($user);
            return redirect()->route('profile.show')->with('status', 'Usuário administrativo PSE criado com sucesso!');
        } else {
            $user->password = Hash::make($initialAdminPassword);
            $user->tipo_perfil = 'pse';
            $user->save();
            Log::info("Usuário administrativo PSE '{$adminEmail}' atualizado com sucesso.");
            Auth::login($user);
            return redirect()->route('profile.show')->with('status', 'Usuário administrativo PSE atualizado com sucesso!');
        }
    }
}
