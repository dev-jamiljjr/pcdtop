<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JovemController extends Controller
{
    /**
     * Exibe a lista de candidaturas do jovem logado.
     */
    public function showMyCandidaturas(): View
    {
        if (!Auth::check() || Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem visualizar suas candidaturas.');
        }

        $jovem = Auth::user()->jovem;

        if (!$jovem) {
            return redirect()->route('jovem.curriculo.step1')->with('error', 'Por favor, complete seu perfil de jovem para visualizar suas candidaturas.');
        }

        // <<< INÍCIO DA CORREÇÃO >>>
        // Para ordenar pelo título da vaga, precisamos fazer um join com a tabela 'vagas'.
        $candidaturas = Candidatura::where('jovem_id', $jovem->id)
                                   ->join('vagas', 'candidaturas.vaga_id', '=', 'vagas.id')
                                   ->select('candidaturas.*') // Seleciona todas as colunas de candidaturas
                                   ->with('vaga.empresa') // Carrega a vaga e a empresa associada
                                   ->orderBy('vagas.titulo', 'asc') // Ordena pelo título da vaga
                                   ->paginate(10);
        // <<< FIM DA CORREÇÃO >>>

        return view('jovem.candidaturas.index', compact('candidaturas'));
    }
}
