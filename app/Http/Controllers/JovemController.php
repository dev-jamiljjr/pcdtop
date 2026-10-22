<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JovemController extends Controller
{
    /**
     * Exibe a página "Minhas Candidaturas" para o jovem logado.
     */
    public function showMyCandidaturas(): View
    {
        // 1. Autorização: Verificar se o usuário logado é um jovem.
        if (Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem visualizar suas candidaturas.');
        }

        // 2. Obter o perfil do jovem logado.
        $jovem = Auth::user()->jovem;

        // Se o perfil jovem não existir por algum motivo, redirecionar com erro.
        if (!$jovem) {
            // Este cenário é improvável se o registro for consistente, mas é uma boa prática.
            return redirect()->route('home')->with('error', 'Seu perfil de jovem não foi encontrado.');
        }

        // 3. Buscar as candidaturas do jovem, carregando dados relacionados para otimização.
        // O `with` evita múltiplas consultas ao banco de dados (problema N+1).
        $candidaturas = $jovem->candidaturas()
                              ->with(['vaga.empresa'])
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        // 4. Retornar a view com os dados das candidaturas.
        return view('jovem.candidaturas.index', compact('candidaturas'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
