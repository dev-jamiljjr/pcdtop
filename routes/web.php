<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\PseController;
use App\Http\Middleware\CheckPseProfile; // IMPORTAÇÃO DA CLASSE DO MIDDLEWARE

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal que carrega a view 'home'
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas para as páginas principais (sem autenticação explícita)
Route::get('/jovem', function () { return view('jovem.index'); })->name('jovem.index');
Route::get('/empresa', function () { return view('empresa.index'); })->name('empresa.index');
Route::get('/pse', function () { return view('pse.index'); })->name('pse.index');

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

    // Rotas para Gerenciamento de Vagas (Empresa)
    Route::resource('vagas', VagaController::class)->except(['show']);
    // Rota para Consulta de Vagas (Jovem)
    Route::get('/vagas/buscar', [VagaController::class, 'search'])->name('vagas.search');
    // Rota para Visualização de Detalhes da Vaga (Jovem e Empresa)
    Route::get('/vagas/{vaga}', [VagaController::class, 'show'])->name('vagas.show');

    // Rotas para a Área Administrativa do PSE
    Route::prefix('admin/pse')->name('pse.')->middleware(CheckPseProfile::class)->group(function () { // A CORREÇÃO ESTÁ AQUI
        Route::get('/', [PseController::class, 'dashboard'])->name('dashboard');
        Route::get('/jovens', [PseController::class, 'listJovens'])->name('jovens.index');
        Route::get('/empresas', [PseController::class, 'listEmpresas'])->name('empresas.index');
        Route::get('/vagas', [PseController::class, 'listVagas'])->name('vagas.index');
    });
});

// Mantenha as outras rotas de autenticação no final
require __DIR__.'/auth.php';
