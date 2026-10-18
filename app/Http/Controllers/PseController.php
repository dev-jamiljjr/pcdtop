<?php

namespace App\Http\Controllers;

use App\Models\User; // Assumindo que Jovens e Empresas são tipos de User
use App\Models\Vaga;
use Illuminate\Http\Request;

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
}
