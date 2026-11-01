<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Jovem;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class JovemProfileController extends Controller
{
    // ... (o topo do arquivo permanece o mesmo) ...

    /**
     * Processa os dados da Etapa 1: Dados Pessoais e avança para a próxima etapa.
     */
    public function processStep1(Request $request): RedirectResponse
    {
        // ... (código do processStep1 que você já tem, que está correto) ...
    }

    /**
     * Exibe o formulário da Etapa 2: Endereço.
     */
    public function showStep2Form(Request $request): View
    {
        $user = Auth::user();
        $jovem = $user->jovem ?? new Jovem();
        // Os dados da sessão são usados como fallback, mas os dados do banco têm prioridade
        $data = $request->session()->get(self::SESSION_KEY, []);

        return view('jovem.curriculo.step2', compact('data', 'jovem', 'user'));
    }

    /**
     * Processa os dados da Etapa 2: Endereço e avança para a próxima etapa.
     */
    public function processStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'endereco' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:100'], // Adicionado
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
            'cep' => ['nullable', 'string', 'max:10'], // Adicionado
        ]);

        $request->session()->put(self::SESSION_KEY . '.step2', $validated);

        return redirect()->route('jovem.curriculo.step3');
    }

    // ... (restante dos métodos do controller permanecem os mesmos) ...

    /**
     * Processa os dados da Etapa 4: Finalizar (Upload de Currículo) e salva o perfil.
     */
    public function processStep4(Request $request): RedirectResponse
    {
        // ... (código do processStep4 que você já tem, que está correto) ...
    }
}
