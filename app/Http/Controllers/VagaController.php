<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class VagaController extends Controller
{
    /**
     * Exibe uma listagem das vagas da empresa logada.
     */
    public function index(): View
    {
        // Garante que apenas empresas possam acessar esta funcionalidade
        if (Auth::user()->tipo_perfil !== 'empresa') {
            abort(403, 'Acesso não autorizado. Apenas empresas podem gerenciar vagas.');
        }

        $empresa = Auth::user()->empresa;
        $vagas = $empresa->vagas()->latest()->paginate(10); // Pagina as vagas, mais recentes primeiro

        return view('vagas.index', compact('vagas'));
    }

    /**
     * Exibe o formulário para criar uma nova vaga.
     */
    public function create(): View
    {
        if (Auth::user()->tipo_perfil !== 'empresa') {
            abort(403, 'Acesso não autorizado. Apenas empresas podem criar vagas.');
        }
        return view('vagas.create');
    }

    /**
     * Armazena uma vaga recém-criada no banco de dados.
     */
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

    /**
     * Exibe os detalhes de uma vaga específica.
     */
    public function show(Vaga $vaga): View
    {
        // Autoriza que jovens vejam qualquer vaga, e empresas vejam suas próprias vagas
        if (Auth::user()->tipo_perfil === 'empresa' && Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar esta vaga.');
        }
        return view('vagas.show', compact('vaga'));
    }

    /**
     * Exibe o formulário para editar uma vaga específica.
     */
    public function edit(Vaga $vaga): View
    {
        // Autoriza que apenas a empresa dona da vaga possa editá-la
        if (Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para editar esta vaga.');
        }
        return view('vagas.edit', compact('vaga'));
    }

    /**
     * Atualiza uma vaga específica no banco de dados.
     */
    public function update(Request $request, Vaga $vaga): RedirectResponse
    {
        // Autoriza que apenas a empresa dona da vaga possa atualizá-la
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

    /**
     * Remove uma vaga específica do banco de dados.
     */
    public function destroy(Vaga $vaga): RedirectResponse
    {
        // Autoriza que apenas a empresa dona da vaga possa excluí-la
        if (Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para excluir esta vaga.');
        }

        $vaga->delete();

        return redirect()->route('vagas.index')->with('status', 'Vaga excluída com sucesso!');
    }

    // --- Métodos para Jovem ---

    /**
     * Exibe uma listagem de todas as vagas disponíveis para jovens.
     */
    public function search(Request $request): View
    {
        // Garante que apenas jovens possam acessar esta funcionalidade
        if (Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem consultar vagas.');
        }

        // Busca todas as vagas ativas, ordenadas pelas mais recentes
        $vagas = Vaga::where('status', 'ativa')->latest()->paginate(10);
        return view('vagas.search', compact('vagas'));
    }
}
