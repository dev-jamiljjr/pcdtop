<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\PseController;
use App\Http\Controllers\JovemController; // Import adicionado
use App\Http\Middleware\CheckPseProfile;

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


// Grupo de rotas que exigem autenticação
Route::middleware('auth')->group(function () {
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
    // Gerenciamento de Vagas (Empresa)
    Route::resource('vagas', VagaController::class)->except(['show']);
    // Visualizar Candidatos de uma Vaga Específica (Empresa)
    Route::get('/vagas/{vaga}/candidatos', [VagaController::class, 'showCandidatos'])->name('vagas.candidatos.index');
    // Visualizar o Perfil de um Jovem Candidato (pela Empresa)
    Route::get('/vagas/{vaga}/candidatos/{jovem}/perfil', [VagaController::class, 'showJovemProfile'])->name('vagas.candidatos.jovem.show');
    // Atualizar o status de uma candidatura específica
    Route::post('/vagas/{vaga}/candidatos/{candidatura}/status', [VagaController::class, 'updateCandidaturaStatus'])->name('vagas.candidatos.updateStatus');

    // Consulta de Vagas (Jovem)
    Route::get('/vagas/buscar', [VagaController::class, 'search'])->name('vagas.search');
    // Visualização de Detalhes da Vaga (Jovem e Empresa)
    Route::get('/vagas/{vaga}', [VagaController::class, 'show'])->name('vagas.show');
    // Candidatura do Jovem a uma Vaga
    Route::post('/vagas/{vaga}/candidatar', [VagaController::class, 'apply'])->name('vagas.apply');

    // --- ROTA PARA MINHAS CANDIDATURAS (JOVEM) ---
    Route::get('/jovem/minhas-candidaturas', [JovemController::class, 'showMyCandidaturas'])->name('jovem.candidaturas');

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
