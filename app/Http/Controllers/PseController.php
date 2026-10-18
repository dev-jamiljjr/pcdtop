<?php

namespace App\Http\Controllers;

use App\Models\User; // Assumindo que Jovens e Empresas são tipos de User
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Importar a classe Hash
use Illuminate\Support\Facades\Log;   // Importar a classe Log
use Illuminate\Support\Facades\Auth; // Importar Auth para logs e redirects

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
     * Lista todos os jovens cadastrados, ordenados alfabeticamente.
     */
    public function listJovens()
    {
        $jovens = User::where('tipo_perfil', 'jovem')->orderBy('name', 'asc')->paginate(10); // Ordena pelo nome
        return view('pse.jovens.index', compact('jovens'));
    }

    /**
     * Lista todas as empresas cadastradas, ordenadas alfabeticamente.
     */
    public function listEmpresas()
    {
        $empresas = User::where('tipo_perfil', 'empresa')->orderBy('name', 'asc')->paginate(10); // Ordena pelo nome
        return view('pse.empresas.index', compact('empresas'));
    }

    /**
     * Lista todas as vagas cadastradas, ordenadas alfabeticamente pelo título.
     */
    public function listVagas()
    {
        $vagas = Vaga::orderBy('titulo', 'asc')->paginate(10); // Ordena pelo título da vaga
        return view('pse.vagas.index', compact('vagas'));
    }

    /**
     * Exibe o formulário para inserir a senha de ativação do administrador.
     */
    public function showAdminActivationForm()
    {
        // Esta página só deve ser acessível se o usuário NÃO estiver logado
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
        // Esta ação só deve ser processada se o usuário NÃO estiver logado
        if (Auth::check()) {
            return redirect('/');
        }

        $request->validate([
            'activation_password' => ['required', 'string'],
        ]);

        $inputPassword = $request->input('activation_password');
        $storedHash = config('app.pse_activation_key_hash'); // Acessa o hash do .env

        // Verifica se o hash está configurado
        if (empty($storedHash)) {
            Log::warning('PSE_ACTIVATION_KEY_HASH não configurado no .env!');
            return back()->with('error', 'Erro de configuração: Chave de ativação não encontrada.');
        }

        // Compara a senha fornecida com o hash armazenado
        if (!Hash::check($inputPassword, $storedHash)) {
            Log::warning('Tentativa de ativação de administrador com senha incorreta: ' . $inputPassword);
            return back()->with('error', 'Senha de ativação incorreta.');
        }

        // Credenciais corretas, prosseguir com a lógica
        $adminEmail = 'sereficiente@30dejulho.com.br';
        $initialAdminPassword = 'pse@CEB1947'; // A senha que será setada no usuário

        $user = User::where('email', $adminEmail)->first();

        if (!$user) {
            // Se o usuário não existe, criá-lo
            $user = User::create([
                'name' => 'PSE Admin', // Nome padrão para o admin
                'email' => $adminEmail,
                'password' => Hash::make($initialAdminPassword), // Hasheia a senha inicial
                'tipo_perfil' => 'pse',
            ]);
            Log::info("Usuário administrativo PSE '{$adminEmail}' criado com sucesso.");
            Auth::login($user); // Loga o usuário administrativo automaticamente
            return redirect()->route('profile.show')->with('status', 'Usuário administrativo PSE criado com sucesso!');
        } else {
            // Se o usuário existe, garantir que o perfil seja 'pse' e a senha seja a padrão
            $user->password = Hash::make($initialAdminPassword);
            $user->tipo_perfil = 'pse';
            $user->save();
            Log::info("Usuário administrativo PSE '{$adminEmail}' atualizado com sucesso.");
            Auth::login($user); // Loga o usuário administrativo automaticamente
            return redirect()->route('profile.show')->with('status', 'Usuário administrativo PSE atualizado com sucesso!');
        }
    }
}
