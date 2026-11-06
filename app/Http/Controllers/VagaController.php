<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Candidatura;
use App\Models\Jovem;
use App\Models\User; // Importar o modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $userCandidatura = null;
        if (Auth::check() && Auth::user()->tipo_perfil === 'jovem') {
            $jovem = Auth::user()->jovem;
            if ($jovem) {
                $userCandidatura = Candidatura::where('jovem_id', $jovem->id)
                                              ->where('vaga_id', $vaga->id)
                                              ->first();
            }
        }

        $backUrl = session('vagas_return_url', route('vagas.search'));

        return view('vagas.show', compact('vaga', 'userCandidatura', 'backUrl'));
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

        // <<< ALTERAÇÃO AQUI: Filtra vagas de empresas ativas >>>
        $vagas = Vaga::where('status', 'ativa')
                     ->whereHas('empresa', function ($query) {
                         $query->whereHas('user', function ($userQuery) {
                             $userQuery->where('status', User::STATUS_ATIVO);
                         });
                     })
                     ->orderBy('titulo', 'asc')
                     ->paginate(10);

        session()->put('vagas_return_url', $request->fullUrl());

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

        // <<< ADIÇÃO AQUI: Verifica se a empresa está ativa antes de permitir a candidatura >>>
        if ($vaga->empresa->user->isBlocked()) {
            return redirect()->back()->with('error', 'Não é possível candidatar-se a esta vaga no momento. A empresa está aguardando aprovação ou foi bloqueada.');
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

        // <<< ALTERAÇÃO AQUI: Filtra candidaturas de jovens ativos >>>
        $candidaturas = $vaga->candidaturas()
                             ->join('jovens', 'candidaturas.jovem_id', '=', 'jovens.id')
                             ->join('users', 'jovens.user_id', '=', 'users.id') // Join com a tabela users do jovem
                             ->where('users.status', User::STATUS_ATIVO)       // Filtra por status ativo
                             ->select('candidaturas.*')
                             ->with(['jovem.user'])
                             ->orderBy('users.name', 'asc')
                             ->paginate(10);

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

        // <<< ALTERAÇÃO AQUI: Verifica o status do jovem antes de exibir o perfil >>>
        // Carrega o usuário associado ao jovem para verificar o status
        $jovem->load('user');
        if ($jovem->user->isBlocked()) {
            abort(403, 'Acesso não autorizado. O perfil deste jovem está bloqueado e não pode ser visualizado.');
        }
        // <<< FIM DA ALTERAÇÃO >>>

        $candidatura = Candidatura::where('jovem_id', $jovem->id)
                                  ->where('vaga_id', $vaga->id)
                                  ->first();

        if (!$candidatura) {
            abort(403, 'Acesso não autorizado. Este jovem não se candidatou a esta vaga.');
        }

        // Se o status da candidatura for 'Pendente', atualiza para 'Visualizado'
        if ($candidatura->status === Candidatura::STATUS_PENDENTE) {
            $candidatura->update(['status' => Candidatura::STATUS_VISUALIZADO]);
            // Opcional: Adicionar uma mensagem de status para a empresa (pode ser útil para feedback imediato)
            session()->flash('status', 'O status da candidatura foi atualizado para "Visualizado".');
        }

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

    /**
     * Permite que um jovem desista de uma candidatura pendente.
     */
    public function cancelApplication(Vaga $vaga, Request $request): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->tipo_perfil !== 'jovem') {
            abort(403, 'Acesso não autorizado. Apenas jovens podem desistir de candidaturas.');
        }

        $jovem = Auth::user()->jovem;
        if (!$jovem) {
            return redirect()->route('jovem.curriculo.step1')->with('error', 'Seu perfil de jovem não está completo.');
        }

        $candidatura = Candidatura::where('jovem_id', $jovem->id)
                                  ->where('vaga_id', $vaga->id)
                                  ->first();

        if (!$candidatura) {
            return redirect()->back()->with('error', 'Candidatura não encontrada.');
        }

        if ($candidatura->status !== Candidatura::STATUS_PENDENTE) {
            return redirect()->back()->with('warning', 'Não é possível desistir de uma candidatura que não está "Pendente".');
        }

        $candidatura->delete();

        return redirect()->back()->with('status', 'Candidatura retirada com sucesso!');
    }

    /**
     * Permite à empresa visualizar o currículo PDF de um jovem, atualizando o status da candidatura.
     */
    public function viewJovemCurriculoPdf(Vaga $vaga, Jovem $jovem): StreamedResponse|RedirectResponse
    {
        if (Auth::user()->tipo_perfil !== 'empresa' || Auth::user()->id !== $vaga->empresa->user_id) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para visualizar este currículo.');
        }

        // <<< ALTERAÇÃO AQUI: Verifica o status do jovem antes de permitir a visualização do currículo PDF >>>
        // Carrega o usuário associado ao jovem para verificar o status
        $jovem->load('user');
        if ($jovem->user->isBlocked()) {
            return redirect()->back()->with('error', 'O currículo deste jovem está bloqueado e não pode ser visualizado no momento.');
        }
        // <<< FIM DA ALTERAÇÃO >>>

        $candidatura = Candidatura::where('jovem_id', $jovem->id)
                                  ->where('vaga_id', $vaga->id)
                                  ->first();

        if (!$candidatura) {
            return redirect()->back()->with('error', 'Candidatura não encontrada para a vaga especificada.');
        }

        // Se o status da candidatura for 'Pendente', atualiza para 'Visualizado'
        if ($candidatura->status === Candidatura::STATUS_PENDENTE) {
            $candidatura->update(['status' => Candidatura::STATUS_VISUALIZADO]);
            session()->flash('status', 'O status da candidatura foi atualizado para "Visualizado" após a visualização do currículo.');
        }

        if (!$jovem->curriculo_path || !Storage::disk('public')->exists($jovem->curriculo_path)) {
            return redirect()->back()->with('error', 'Currículo PDF não encontrado.');
        }

        // Retorna o arquivo PDF para ser exibido no navegador
        return Storage::disk('public')->response($jovem->curriculo_path, $jovem->user->name . '_curriculo.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $jovem->user->name . '_curriculo.pdf"',
        ]);
    }
}
