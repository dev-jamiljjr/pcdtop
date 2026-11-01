<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\PseController;
use App\Http\Controllers\JovemController;
use App\Http\Controllers\JovemProfileController;
use App\Http\Middleware\CheckPseProfile;
use App\Http\Controllers\Auth\CustomPasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal que carrega a view 'home'
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas para as páginas principais (públicas)
Route::get('/jovem', function () { return view('jovem.index'); })->name('jovem.index');
Route::get('/empresa', function () { return view('empresa.index'); })->name('empresa.index');
Route::get('/pse', function () { return view('pse.index'); })->name('pse.index');

// Rotas para a funcionalidade "Acesso Admin" (públicas)
Route::get('/acesso-admin', [PseController::class, 'showAdminActivationForm'])->name('pse.show-admin-activation-form');
Route::post('/acesso-admin', [PseController::class, 'activateAdmin'])->name('pse.activate-admin');


// --- ROTAS CUSTOMIZADAS PARA REDEFINIÇÃO DE SENHA (INTERCEPTAM O FLUXO PADRÃO) ---
Route::get('/reset-password/{token}', [CustomPasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [CustomPasswordResetController::class, 'reset'])
    ->middleware('guest')
    ->name('password.store');


// Grupo de rotas que exigem autenticação E E-MAIL VERIFICADO
Route::middleware(['auth', 'verified'])->group(function () { // <-- ADICIONADO 'verified' aqui
    // Rotas de Perfil
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

    // ROTA DE LOGOUT (GET)
    Route::get('/logout-temp', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout.temp');

    // --- Rotas de Vagas ---
    Route::resource('vagas', VagaController::class)->except(['show']);
    Route::get('/vagas/{vaga}/candidatos', [VagaController::class, 'showCandidatos'])->name('vagas.candidatos.index');
    Route::get('/vagas/{vaga}/candidatos/{jovem}/perfil', [VagaController::class, 'showJovemProfile'])->name('vagas.candidatos.jovem.show');
    Route::post('/vagas/{vaga}/candidatos/{candidatura}/status', [VagaController::class, 'updateCandidaturaStatus'])->name('vagas.candidatos.updateStatus');

    // Consulta de Vagas (Jovem)
    Route::get('/vagas/buscar', [VagaController::class, 'search'])->name('vagas.search');
    Route::get('/vagas/{vaga}', [VagaController::class, 'show'])->name('vagas.show');
    Route::post('/vagas/{vaga}/candidatar', [VagaController::class, 'apply'])->name('vagas.apply');

    // --- ROTA PARA MINHAS CANDIDATURAS (JOVEM) ---
    Route::get('/jovem/minhas-candidaturas', [JovemController::class, 'showMyCandidaturas'])->name('jovem.candidaturas');

    // --- ROTAS DO ASSISTENTE DE PERFIL DO JOVEM (Cadastro/Atualização de Currículo) ---
    Route::middleware(['is.jovem'])->prefix('jovem/meu-curriculo')->name('jovem.curriculo.')->group(function () {
        Route::get('/etapa-1', [JovemProfileController::class, 'showStep1Form'])->name('step1');
        Route::post('/etapa-1', [JovemProfileController::class, 'processStep1'])->name('step1.process');
        Route::get('/etapa-2', [JovemProfileController::class, 'showStep2Form'])->name('step2');
        Route::post('/etapa-2', [JovemProfileController::class, 'processStep2'])->name('step2.process');
        Route::get('/etapa-3', [JovemProfileController::class, 'showStep3Form'])->name('step3');
        Route::post('/etapa-3', [JovemProfileController::class, 'processStep3'])->name('step3.process');
        Route::get('/etapa-4', [JovemProfileController::class, 'showStep4Form'])->name('step4');
        Route::post('/etapa-4', [JovemProfileController::class, 'processStep4'])->name('step4.process');

        Route::get('/', function() {
            return redirect()->route('jovem.curriculo.step1');
        })->name('index');
    });

    // --- Rotas Administrativas do PSE ---
    Route::prefix('admin/pse')->name('pse.')->middleware(CheckPseProfile::class)->group(function () {
        Route::get('/', [PseController::class, 'dashboard'])->name('dashboard');
        Route::get('/jovens', [PseController::class, 'listJovens'])->name('jovens.index');
        Route::get('/jovens/{jovem}', [PseController::class, 'showJovem'])->name('jovens.show');
        Route::get('/empresas', [PseController::class, 'listEmpresas'])->name('empresas.index');
        Route::get('/vagas', [PseController::class, 'listVagas'])->name('vagas.index');
        Route::get('/candidaturas', [PseController::class, 'listCandidaturas'])->name('candidaturas.index');
    });
});

// Mantenha as outras rotas de autenticação no final
require __DIR__.'/auth.php';
