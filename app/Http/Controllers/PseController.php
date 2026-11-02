<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaga;
use App\Models\Candidatura;
use App\Models\Jovem;
use App\Models\Empresa;
use Illuminate\Http\Request; // Certifique-se de que esta linha está presente
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PseController extends Controller
{
    /**
     * Exibe o dashboard administrativo do PSE.
     */
    public function dashboard(): View
    {
        $totalJovens = User::where('tipo_perfil', 'jovem')->count();
        $totalEmpresas = User::where('tipo_perfil', 'empresa')->count();
        $totalVagas = Vaga::count();
        $totalCandidaturas = Candidatura::count();

        return view('pse.dashboard', compact('totalJovens', 'totalEmpresas', 'totalVagas', 'totalCandidaturas'));
    }

    /**
     * Lista todos os jovens cadastrados, ordenados alfabeticamente e carrega os detalhes do perfil jovem.
     */
    public function listJovens(): View
    {
        $jovens = User::where('tipo_perfil', 'jovem')
                      ->with('jovem')
                      ->orderBy('name', 'asc')
                      ->paginate(10);
        return view('pse.jovens.index', compact('jovens'));
    }

    /**
     * Exibe o perfil completo de um jovem específico para o PSE.
     */
    public function showJovem(Jovem $jovem): View
    {
        $jovem->load('user');

        return view('pse.jovens.show', compact('jovem'));
    }

    /**
     * Lista todas as empresas cadastradas, ordenadas alfabeticamente.
     */
    public function listEmpresas(): View
    {
        $empresas = User::where('tipo_perfil', 'empresa')
                        ->with('empresa')
                        ->orderBy('name', 'asc')
                        ->paginate(10);
        return view('pse.empresas.index', compact('empresas'));
    }

    /**
     * Exibe o perfil completo de uma empresa específica para o PSE.
     */
    public function showEmpresa(Empresa $empresa): View
    {
        $empresa->load(['user', 'contatos']);
        return view('pse.empresas.show', compact('empresa'));
    }

    /**
     * Lista todas as vagas cadastradas, ordenadas alfabeticamente pelo título.
     */
    public function listVagas(): View
    {
        // --- INÍCIO DA ALTERAÇÃO ---
        // Salva a URL da lista de vagas do PSE na sessão para o botão Voltar
        session()->put('vagas_return_url', route('pse.vagas.index'));
        // --- FIM DA ALTERAÇÃO ---

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

    /**
     * Lista todas as candidaturas registradas no sistema para o PSE.
     */
    public function listCandidaturas(): View
    {
        if (Auth::user()->tipo_perfil !== 'pse') {
            abort(403, 'Acesso não autorizado. Apenas administradores PSE podem visualizar as candidaturas.');
        }

        // --- INÍCIO DA ALTERAÇÃO ---
        // Salva a URL da lista de candidaturas do PSE na sessão para o botão Voltar
        session()->put('vagas_return_url', route('pse.candidaturas.index'));
        // --- FIM DA ALTERAÇÃO ---

        $candidaturas = Candidatura::select('candidaturas.*')
                                   ->join('jovens', 'candidaturas.jovem_id', '=', 'jovens.id')
                                   ->join('users', 'jovens.user_id', '=', 'users.id')
                                   ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.id')
                                   ->with(['jovem.user', 'vaga.empresa'])
                                   ->orderBy('users.name', 'asc')
                                   ->orderBy('vagas.titulo', 'asc')
                                   ->paginate(15);

        return view('pse.candidaturas.index', compact('candidaturas'));
    }
}
