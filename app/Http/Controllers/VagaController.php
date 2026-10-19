<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Candidatura;
use App\Models\Jovem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class VagaController extends Controller
{
    /**
     * Exibe uma listagem das vagas da empresa logada, com a contagem de candidaturas.
     */
    public function index(): View
    {
        if (Auth::user()->tipo_perfil !== 'empresa') {
            abort(403, 'Acesso não autorizado. Apenas empresas podem gerenciar vagas.');
        }

        $empresa = Auth::user()->empresa;
        // Carrega as vagas com a contagem de candidaturas associadas
        $vagas = $empresa->vagas()
                         ->withCount('candidaturas')
                         ->orderBy('titulo', 'asc')
                         ->paginate(10);

        return view('vagas.index', compact('vagas'));
    }

    public function create(): View
    {
        if (Auth::user()->tipo_perfil !== 'empresa') {
            abort(403, 'Acesso não autorizado. Apenas empresas podem criar vagas.');
        }
        return view('vagas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->tipo_perfil !== 'empresa') {
            abort(403, 'Acesso não autorizado. Apenas empresas podem criar vagas.');
        }
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'requisitos' => ['nullable', 'string'],
            'localizacao' => ['required', 'string', 'max:255'],
            'tipo_contrato' => ['required', 'string', Rule::in(['CLT', 'PJ', 'Estágio', 'Temporário'])],
            'salario' => ['nullable', 'numeric', 'min:0'],
            'beneficios' => ['nullable', 'string'],
        ]);
        Auth::user()->empresa->vagas()->create($validated);
        return redirect()->route('vagas.index')->with('status', 'Vaga criada com sucesso!');
    }

    public function show(Vaga $vaga): View
    {
        if (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar esta vaga.');
        }

        $candidatado = false;
        if (Auth::check() && Auth::user()->tipo_perfil === 'jovem') {
            $jovem = Auth::user()->jovem;
            if ($jovem) {
                $candidatado = Candidatura::where('jovem_id', $jovem->id)
                                          ->where('vaga_id', $vaga->id)
                                          ->exists();
            }
        }

        return view('vagas.show', compact('vaga', 'candidatado'));
    }

    public function edit(Vaga $vaga): View
    {
        if (Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para editar esta vaga.');
        }
        return view('vagas.edit', compact('vaga'));
    }

    public function update(Request $request, Vaga $vaga): RedirectResponse
    {
        if (Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para atualizar esta vaga.');
        }
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'requisitos' => ['nullable', 'string'],
            'localizacao' => ['required', 'string', 'max:255'],
            'tipo_contrato' => ['required', 'string', Rule::in(['CLT', 'PJ', 'Estágio', 'Temporário'])],
            'salario' => ['nullable', 'numeric', 'min:0'],
            'beneficios' => ['nullable', 'string'],
        ]);
        $vaga->update($validated);
        return redirect()->route('vagas.index')->with('status', 'Vaga atualizada com sucesso!');
    }

    public function destroy(Vaga $vaga): RedirectResponse
    {
        if (Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para excluir esta vaga.');
        }
        $vaga->delete();
        return redirect()->route('vagas.index')->with('status', 'Vaga excluída com sucesso!');
    }

    public function search(Request $request): View
    {
        if (Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem consultar vagas.');
        }
        $vagas = Vaga::where('status', 'ativa')->orderBy('titulo', 'asc')->paginate(10);
        return view('vagas.search', compact('vagas'));
    }

    public function apply(Request $request, Vaga $vaga): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem se candidatar a vagas.');
        }

        $jovem = Auth::user()->jovem;
        if (!$jovem) {
            return redirect()->back()->with('error', 'Seu perfil de jovem não está completo. Por favor, preencha seu currículo antes de se candidatar.');
        }

        $existingCandidatura = Candidatura::where('jovem_id', $jovem->id)
                                        ->where('vaga_id', $vaga->id)
                                        ->first();
        if ($existingCandidatura) {
            return redirect()->back()->with('warning', 'Você já se candidatou a esta vaga.');
        }

        Candidatura::create([
            'jovem_id' => $jovem->id,
            'vaga_id' => $vaga->id,
            'status' => 'pendente',
        ]);

        return redirect()->back()->with('status', 'Candidatura realizada com sucesso!');
    }

    /**
     * Exibe a lista de candidatos para uma vaga específica da empresa.
     */
    public function showCandidatos(Vaga $vaga): View
    {
        // Autorização: Apenas a empresa dona da vaga pode ver os candidatos
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar os candidatos desta vaga.');
        }

        // Carrega as candidaturas para a vaga, com os dados completos do jovem associado
        $candidaturas = $vaga->candidaturas()
                             ->with(['jovem.user']) // Carrega o jovem e seu usuário associado
                             ->orderBy('created_at', 'desc') // Ordena as candidaturas pelas mais recentes
                             ->paginate(10);

        return view('vagas.candidatos.index', compact('vaga', 'candidaturas'));
    }

    /**
     * Exibe o perfil completo de um jovem candidato para a empresa.
     */
    public function showJovemProfile(Vaga $vaga, Jovem $jovem): View
    {
        // 1. Autorização: Verificar se a empresa logada é dona da vaga
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar este perfil.');
        }

        // 2. Autorização: Verificar se o jovem realmente se candidatou a esta vaga
        $candidaturaExiste = Candidatura::where('jovem_id', $jovem->id)
                                        ->where('vaga_id', $vaga->id)
                                        ->exists();

        if (!$candidaturaExiste) {
            abort(403, 'Acesso não autorizado. Este jovem não se candidatou a esta vaga.');
        }

        // 3. Carregar os dados completos do jovem, incluindo o usuário associado
        $jovem->load('user');

        return view('vagas.candidatos.jovem.show', compact('vaga', 'jovem'));
    }
}
