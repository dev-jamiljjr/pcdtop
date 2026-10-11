<?php

use Illuminate\Http\Request; // Adicionado para a rota de logout
use Illuminate\Support\Facades\Auth; // Adicionado para a rota de logout
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal que carrega a view 'home'
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas para as páginas principais
Route::get('/jovem', function () { return view('jovem.index'); })->name('jovem.index');
Route::get('/empresa', function () { return view('empresa.index'); })->name('empresa.index');
Route::get('/pse', function () { return view('pse.index'); })->name('pse.index');

// Grupo de rotas que exigem autenticação
Route::middleware('auth')->group(function () {
    // Rotas de Perfil
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

    // ROTA DE LOGOUT TEMPORÁRIA (GET) - AGORA COM LÓGICA DIRETA
    Route::get('/logout-temp', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout.temp');
});

// Mantenha as outras rotas de autenticação no final
require __DIR__.'/auth.php';
