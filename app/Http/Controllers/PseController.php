<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaga;
use App\Models\Candidatura;
use App\Models\Jovem;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PseController extends Controller
{
    /**
     * Exibe o dashboard administrativo do PSE.
     */
    public function dashboard(): View
    {
        // Limpa a URL de retorno ao voltar para o dashboard para evitar comportamento inesperado
        session()->forget('pse_users_return_url');

        $totalJovens = User::where('tipo_perfil', 'jovem')->count();
        $totalEmpresas = User::where('tipo_perfil', 'empresa')->count();
        $totalVagas = Vaga::count();
        $totalCandidaturas = Candidatura::count();
        
        $jovensBloqueados = User::where('tipo_perfil', 'jovem')->where('status', User::STATUS_BLOQUEADO)->count();
        $empresasBloqueadas = User::where('tipo_perfil', 'empresa')->where('status', User::STATUS_BLOQUEADO)->count();

        return view('pse.dashboard', compact(
            'totalJovens', 
            'totalEmpresas', 
            'totalVagas', 
            'totalCandidaturas',
            'jovensBloqueados',
            'empresasBloqueadas'
        ));
    }

    /**
     * Lista todos os jovens cadastrados.
     */
    public function listJovens(Request $request): View
    {
        session()->put('pse_users_return_url', $request->fullUrl());

        $jovens = User::where('tipo_perfil', 'jovem')
                      ->with('jovem')
                      ->orderBy('name', 'asc')
                      ->paginate(10);
        return view('pse.jovens.index', compact('jovens'));
    }
    
    /**
     * Lista apenas os jovens com status 'bloqueado'.
     */
    public function listJovensBloqueados(Request $request): View
    {
        session()->put('pse_users_return_url', $request->fullUrl());

        $jovens = User::where('tipo_perfil', 'jovem')
                      ->where('status', User::STATUS_BLOQUEADO)
                      ->with('jovem')
                      ->orderBy('name', 'asc')
                      ->paginate(10);
        return view('pse.jovens.index_bloqueados', compact('jovens'));
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
     * Lista todas as empresas cadastradas.
     */
    public function listEmpresas(Request $request): View
    {
        session()->put('pse_users_return_url', $request->fullUrl());

        $empresas = User::where('tipo_perfil', 'empresa')
                        ->with('empresa')
                        ->orderBy('name', 'asc')
                        ->paginate(10);
        return view('pse.empresas.index', compact('empresas'));
    }

    /**
     * Lista apenas as empresas com status 'bloqueado'.
     */
    public function listEmpresasBloqueadas(Request $request): View
    {
        session()->put('pse_users_return_url', $request->fullUrl());

        $empresas = User::where('tipo_perfil', 'empresa')
                        ->where('status', User::STATUS_BLOQUEADO)
                        ->with('empresa')
                        ->orderBy('name', 'asc')
                        ->paginate(10);
        return view('pse.empresas.index_bloqueadas', compact('empresas'));
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
     * Alterna o status de um usuário (ativo/bloqueado).
     */
    public function toggleUserStatus(User $user): RedirectResponse
    {
        if ($user->tipo_perfil === 'pse') {
            return redirect()->back()->with('error', 'Não é possível alterar o status de um administrador.');
        }

        $user->status = $user->isActive() ? User::STATUS_BLOQUEADO : User::STATUS_ATIVO;
        $user->save();

        $novoStatus = $user->isActive() ? 'ativado' : 'bloqueado';

        return redirect()->back()->with('status', "O usuário {$user->name} foi {$novoStatus} com sucesso.");
    }

    /**
     * Lista todas as vagas cadastradas.
     */
    public function listVagas(): View
    {
        session()->put('vagas_return_url', route('pse.vagas.index'));
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

        $request->validate(['activation_password' => ['required', 'string']]);
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

        $user = User::firstOrNew(['email' => $adminEmail]);
        $user->name = 'PSE Admin';
        $user->password = Hash::make($initialAdminPassword);
        $user->tipo_perfil = 'pse';
        $user->status = User::STATUS_ATIVO;
        $user->save();

        Log::info("Usuário administrativo PSE '{$adminEmail}' criado/atualizado com sucesso.");
        Auth::login($user);
        return redirect()->route('profile.show')->with('status', 'Usuário administrativo PSE criado/atualizado com sucesso!');
    }

    /**
     * Lista todas as candidaturas registradas no sistema.
     */
    public function listCandidaturas(Request $request): View
    {
        if (Auth::user()->tipo_perfil !== 'pse') {
            abort(403, 'Acesso não autorizado.');
        }

        // Armazena a URL da página de Candidaturas na sessão correta para o botão "Voltar" de vagas
        // E também para o retorno de perfis de usuário (jovem/empresa) se for o caso.
        session()->put('pse_users_return_url', $request->fullUrl());
        session()->put('vagas_return_url', $request->fullUrl()); // <<< NOVA LINHA ADICIONADA AQUI

        $candidaturas = Candidatura::with(['jovem.user', 'vaga.empresa'])
                                   ->join('jovens', 'candidaturas.jovem_id', '=', 'jovens.id')
                                   ->join('users', 'jovens.user_id', '=', 'users.id')
                                   ->select('candidaturas.*')
                                   ->orderBy('users.name', 'asc')
                                   ->paginate(15);

        return view('pse.candidaturas.index', compact('candidaturas'));
    }
}
