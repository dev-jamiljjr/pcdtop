<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Jovem; // Importar o modelo Jovem

class JovemProfileController extends Controller
{
    /**
     * Chave da sessão para armazenar os dados do assistente.
     */
    const SESSION_KEY = 'jovem_profile_wizard';

    /**
     * Exibe o formulário da Etapa 1: Dados Pessoais.
     */
    public function showStep1Form(Request $request): View
    {
        // Recuperar dados da sessão ou do perfil do jovem, se existirem
        $data = $request->session()->get(self::SESSION_KEY, []);
        $jovem = Auth::user()->jovem ?? new Jovem(); // Se não tiver perfil jovem, cria um novo

        return view('jovem.curriculo.step1', compact('data', 'jovem'));
    }

    /**
     * Processa os dados da Etapa 1: Dados Pessoais e avança para a próxima etapa.
     */
    public function processStep1(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'data_nascimento' => ['required', 'date'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'genero' => ['required', 'string', 'in:Masculino,Feminino,Outro,Prefiro não dizer'],
            'deficiencia' => ['nullable', 'string', 'max:1000'],
        ], [
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'genero.required' => 'O gênero é obrigatório.',
            'genero.in' => 'O gênero selecionado não é válido.',
        ]);

        // Armazenar os dados validados na sessão
        $request->session()->put(self::SESSION_KEY . '.step1', $validated);

        return redirect()->route('jovem.curriculo.step2');
    }

    /**
     * Exibe o formulário da Etapa 2: Endereço.
     */
    public function showStep2Form(Request $request): View
    {
        $data = $request->session()->get(self::SESSION_KEY, []);
        $jovem = Auth::user()->jovem ?? new Jovem();

        return view('jovem.curriculo.step2', compact('data', 'jovem'));
    }

    /**
     * Processa os dados da Etapa 2: Endereço e avança para a próxima etapa.
     */
    public function processStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'endereco' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
        ]);

        $request->session()->put(self::SESSION_KEY . '.step2', $validated);

        return redirect()->route('jovem.curriculo.step3');
    }

    /**
     * Exibe o formulário da Etapa 3: Formação e Experiência.
     */
    public function showStep3Form(Request $request): View
    {
        $data = $request->session()->get(self::SESSION_KEY, []);
        $jovem = Auth::user()->jovem ?? new Jovem();

        return view('jovem.curriculo.step3', compact('data', 'jovem'));
    }

    /**
     * Processa os dados da Etapa 3: Formação e Experiência e avança para a próxima etapa.
     */
    public function processStep3(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'formacao_academica' => ['nullable', 'string', 'max:2000'],
            'experiencia_profissional' => ['nullable', 'string', 'max:2000'],
            'habilidades' => ['nullable', 'string', 'max:1000'],
            'link_portfolio' => ['nullable', 'url', 'max:255'],
            'link_linkedin' => ['nullable', 'url', 'max:255'],
        ]);

        $request->session()->put(self::SESSION_KEY . '.step3', $validated);

        return redirect()->route('jovem.curriculo.step4');
    }

    /**
     * Exibe o formulário da Etapa 4: Finalizar (Upload de Currículo).
     */
    public function showStep4Form(Request $request): View
    {
        $data = $request->session()->get(self::SESSION_KEY, []);
        $jovem = Auth::user()->jovem ?? new Jovem();

        return view('jovem.curriculo.step4', compact('data', 'jovem'));
    }

    /**
     * Processa os dados da Etapa 4: Finalizar (Upload de Currículo) e salva o perfil.
     */
    public function processStep4(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'curriculo_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'], // 2MB max
        ], [
            'curriculo_pdf.mimes' => 'O currículo deve ser um arquivo PDF.',
            'curriculo_pdf.max' => 'O currículo não pode exceder 2MB.',
        ]);

        // Recupera todos os dados das etapas anteriores da sessão
        $wizardData = $request->session()->get(self::SESSION_KEY, []);
        
        // Combina todos os dados em um único array
        $profileData = array_merge(
            $wizardData['step1'] ?? [],
            $wizardData['step2'] ?? [],
            $wizardData['step3'] ?? []
        );

        // Prepara os dados para persistência
        $jovem = Auth::user()->jovem;

        // Se o jovem não existe, cria um novo perfil e o associa ao usuário
        if (!$jovem) {
            $jovem = Auth::user()->jovem()->create($profileData);
        } else {
            // Atualiza o perfil existente
            $jovem->update($profileData);
        }

        // Lógica para upload do currículo em PDF
        if ($request->hasFile('curriculo_pdf')) {
            // Se já existe um currículo, exclui o antigo
            if ($jovem->curriculo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($jovem->curriculo_path);
            }
            $path = $request->file('curriculo_pdf')->store('curriculos', 'public');
            $jovem->update(['curriculo_path' => $path]);
        }

        // Limpar os dados da sessão após o salvamento
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('profile.show')->with('status', 'Seu currículo foi atualizado com sucesso!');
    }
}
