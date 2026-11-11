<?php

namespace App\Http\Controllers;

use App\Models\Jovem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JovemProfileController extends Controller
{
    private const SESSION_KEY = 'jovem_profile_data';

    public function showStep1Form(): View
    {
        $user = Auth::user();
        $jovem = $user->jovem ?? new Jovem();
        
        // Recupera dados temporários da sessão, se houverem, para preservar durante a navegação
        $sessionData = session(self::SESSION_KEY . '.step1', []);
        if (!empty($sessionData)) {
            $jovem->fill($sessionData);
        }

        return view('jovem.curriculo.step1', compact('user', 'jovem'));
    }

    public function processStep1(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $jovemId = $user->jovem->id ?? null;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => [
                'nullable',
                'string',
                'regex:/^\d{11}$/',
                Rule::unique('jovens', 'cpf')->ignore($jovemId),
            ],
            'data_nascimento' => ['required', 'date'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'genero' => ['required', 'string', Rule::in(['Masculino', 'Feminino', 'Outro', 'Prefiro não dizer'])],
            'deficiencia' => ['nullable', 'string', 'max:1000'],
        ], [
            'cpf.unique' => 'Este CPF já está em uso por outra pessoa.',
            'cpf.regex' => 'O CPF deve conter somente números e ter 11 dígitos.',
        ]);

        $cpfSanitizado = !empty($validated['cpf']) ? (string) preg_replace('/\D/', '', $validated['cpf']) : null;

        $user->forceFill(['name' => $validated['name']])->save();

        $request->session()->put(self::SESSION_KEY . '.step1', [
            'nome_completo' => $validated['name'],
            'cpf' => $cpfSanitizado,
            'data_nascimento' => $validated['data_nascimento'],
            'telefone' => $validated['telefone'],
            'genero' => $validated['genero'],
            'deficiencia' => $validated['deficiencia'],
        ]);

        // Verifica se a requisição veio do botão Voltar da etapa 2 para salvar o estado sem avançar
        if ($request->has('action') && $request->input('action') === 'back') {
            return redirect()->route('jovem.curriculo.step2');
        }

        return redirect()->route('jovem.curriculo.step2');
    }

    public function showStep2Form(): View
    {
        $user = Auth::user();
        $jovem = $user->jovem ?? new Jovem();

        // Se não houver dados na sessão, preenche com os dados salvos no banco para exibição inicial
        $sessionData = session(self::SESSION_KEY . '.step2', [
            'endereco' => $jovem->endereco,
            'bairro' => $jovem->bairro,
            'cidade' => $jovem->cidade,
            'estado' => $jovem->estado,
            'cep' => $jovem->cep,
        ]);
        
        $jovem->fill($sessionData);

        return view('jovem.curriculo.step2', compact('jovem', 'user'));
    }

    public function processStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'endereco' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
            'cep' => ['nullable', 'string', 'max:10'],
        ]);

        $request->session()->put(self::SESSION_KEY . '.step2', $validated);

        if ($request->has('action') && $request->input('action') === 'back') {
            return redirect()->route('jovem.curriculo.step1');
        }

        return redirect()->route('jovem.curriculo.step3');
    }

    public function showStep3Form(): View
    {
        $user = Auth::user();
        $jovem = $user->jovem ?? new Jovem();

        $sessionData = session(self::SESSION_KEY . '.step3', [
            'formacao_academica' => $jovem->formacao_academica,
            'experiencia_profissional' => $jovem->experiencia_profissional,
            'habilidades' => $jovem->habilidades,
            'link_portfolio' => $jovem->link_portfolio,
            'link_linkedin' => $jovem->link_linkedin,
        ]);

        $jovem->fill($sessionData);

        return view('jovem.curriculo.step3', compact('jovem', 'user'));
    }

    public function processStep3(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'formacao_academica' => ['nullable', 'string'],
            'experiencia_profissional' => ['nullable', 'string'],
            'habilidades' => ['nullable', 'string'],
            'link_portfolio' => ['nullable', 'url', 'max:255'],
            'link_linkedin' => ['nullable', 'url', 'max:255'],
        ]);

        $request->session()->put(self::SESSION_KEY . '.step3', $validated);

        if ($request->has('action') && $request->input('action') === 'back') {
            return redirect()->route('jovem.curriculo.step2');
        }

        return redirect()->route('jovem.curriculo.step4');
    }

    public function showStep4Form(): View
    {
        $user = Auth::user();
        $jovem = $user->jovem ?? new Jovem();
        return view('jovem.curriculo.step4', compact('jovem', 'user'));
    }

    public function processStep4(Request $request): RedirectResponse
    {
        if ($request->has('action') && $request->input('action') === 'back') {
            return redirect()->route('jovem.curriculo.step3');
        }

        $request->validate(['curriculo_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048']]);

        $user = Auth::user();
        
        $path = $user->jovem->curriculo_path ?? null;
        if ($request->hasFile('curriculo_pdf')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('curriculo_pdf')->store('curriculos', 'public');
        }

        $step1Data = $request->session()->get(self::SESSION_KEY . '.step1', []);
        $step2Data = $request->session()->get(self::SESSION_KEY . '.step2', []);
        $step3Data = $request->session()->get(self::SESSION_KEY . '.step3', []);

        $dataToSave = array_merge(
            $step1Data,
            $step2Data,
            $step3Data,
            ['curriculo_path' => $path]
        );

        unset($dataToSave['nome_completo']);

        $filteredData = array_filter($dataToSave, function ($value) { return !is_null($value); });

        Jovem::updateOrCreate(['user_id' => $user->id], $filteredData);

        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('profile.show')->with('status', 'Perfil atualizado com sucesso!');
    }
}
