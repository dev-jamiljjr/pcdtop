<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Models\User; // Importar o modelo User para acessar as constantes de status
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JovemController extends Controller
{
    /**
     * Exibe a lista de candidaturas do jovem logado.
     */
    public function showMyCandidaturas(Request $request): View
    {
        if (!Auth::check() || Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem visualizar suas candidaturas.');
        }

        $jovem = Auth::user()->jovem;

        if (!$jovem) {
            return redirect()->route('jovem.curriculo.step1')->with('error', 'Por favor, complete seu perfil de jovem para visualizar suas candidaturas.');
        }

        // <<< INÍCIO DA CORREÇÃO PARA FILTRAR POR EMPRESA ATIVA >>>
        $candidaturas = Candidatura::where('jovem_id', $jovem->id)
                                   ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.id')
                                   ->join('empresas', 'vagas.empresa_id', '=', 'empresas.id') // Join com empresas
                                   ->join('users', 'empresas.user_id', '=', 'users.id')      // Join com users (da empresa)
                                   ->where('users.status', User::STATUS_ATIVO)               // Filtra por empresa ativa
                                   ->select('candidaturas.*') // Seleciona todas as colunas de candidaturas para evitar conflitos de nomes
                                   ->with('vaga.empresa.user') // Carrega a vaga, empresa e o usuário da empresa
                                   ->orderBy('vagas.titulo', 'asc') // Ordena pelo título da vaga
                                   ->paginate(10);
        // <<< FIM DA CORREÇÃO >>>

        // Salva a URL da página de Minhas Candidaturas na sessão
        session()->put('vagas_return_url', $request->fullUrl());

        return view('jovem.candidaturas.index', compact('candidaturas'));
    }
}
