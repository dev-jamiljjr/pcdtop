<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PseController extends Controller
{
    // O MÉTODO __construct() FOI REMOVIDO PARA CORRIGIR O ERRO.
    // A segurança agora é gerenciada no arquivo de rotas.

    /**
     * Exibe o painel administrativo do PSE.
     */
    public function dashboard(): View
    {
        $totalJovens = User::where('tipo_perfil', 'jovem')->count();
        $totalEmpresas = User::where('tipo_perfil', 'empresa')->count();
        $totalVagas = Vaga::count();

        return view('pse.dashboard', compact('totalJovens', 'totalEmpresas', 'totalVagas'));
    }

    /**
     * Exibe a listagem de jovens cadastrados.
     */
    public function listJovens(): View
    {
        $jovens = User::where('tipo_perfil', 'jovem')
                      ->with('jovem')
                      ->latest()
                      ->paginate(10);
        return view('pse.jovens.index', compact('jovens'));
    }

    /**
     * Exibe a listagem de empresas cadastradas.
     */
    public function listEmpresas(): View
    {
        $empresas = User::where('tipo_perfil', 'empresa')
                        ->with('empresa')
                        ->latest()
                        ->paginate(10);
        return view('pse.empresas.index', compact('empresas'));
    }

    /**
     * Exibe a listagem de vagas cadastradas.
     */
    public function listVagas(): View
    {
        $vagas = Vaga::with('empresa.user')
                     ->latest()
                     ->paginate(10);
        return view('pse.vagas.index', compact('vagas'));
    }
}
