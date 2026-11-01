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
            'status' => Candidatura::STATUS_PENDENTE,
        ]);

        return redirect()->back()->with('status', 'Candidatura realizada com sucesso!');
    }

    /**
     * Exibe a lista de candidatos para uma vaga específica da empresa.
     */
    public function showCandidatos(Vaga $vaga): View
    {
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar os candidatos desta vaga.');
        }

        // <<< INÍCIO DA CORREÇÃO >>>
        // Para ordenar pelo nome do jovem (que está no modelo User), precisamos fazer um join.
        $candidaturas = $vaga->candidaturas()
                             ->join('jovens', 'candidaturas.jovem_id', '=', 'jovens.id')
                             ->join('users', 'jovens.user_id', '=', 'users.id')
                             ->select('candidaturas.*') // Seleciona todas as colunas de candidaturas para evitar conflitos
                             ->with(['jovem.user']) // Carrega o jovem e seu usuário associado
                             ->orderBy('users.name', 'asc') // Ordena pelo nome do usuário (jovem)
                             ->paginate(10);
        // <<< FIM DA CORREÇÃO >>>

        return view('vagas.candidatos.index', compact('vaga', 'candidaturas'));
    }

    /**
     * Exibe o perfil completo de um jovem candidato para a empresa.
     */
    public function showJovemProfile(Vaga $vaga, Jovem $jovem): View
    {
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar este perfil.');
        }

        $candidaturaExiste = Candidatura::where('jovem_id', $jovem->id)
                                        ->where('vaga_id', $vaga->id)
                                        ->exists();

        if (!$candidaturaExiste) {
            abort(403, 'Acesso não autorizado. Este jovem não se candidatou a esta vaga.');
        }

        $jovem->load('user');

        return view('vagas.candidatos.jovem.show', compact('vaga', 'jovem'));
    }

    /**
     * Atualiza o status de uma candidatura para uma vaga específica.
     */
    public function updateCandidaturaStatus(Request $request, Vaga $vaga, Candidatura $candidatura): RedirectResponse
    {
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            return redirect()->back()->with('error', 'Acesso não autorizado. Você não tem permissão para alterar o status desta candidatura.');
        }

        if ($candidatura->vaga_id !== $vaga->id) {
            return redirect()->back()->with('error', 'Candidatura não encontrada para a vaga especificada.');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Candidatura::STATUS_LABELS))],
        ], [
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado não é válido.',
        ]);

        $candidatura->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Status da candidatura atualizado com sucesso para "' . $candidatura->status_label . '".');
    }
}
