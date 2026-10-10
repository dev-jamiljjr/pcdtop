<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; // Importação do ProfileController adicionada ao topo

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal que carrega a view 'home'
Route::get('/', function () {
    return view('home');
})->name('home');

// Rota para a página do Jovem
Route::get('/jovem', function () {
    return view('jovem.index'); // Usaremos uma subpasta para organizar
})->name('jovem.index');

// Rota para a página da Empresa
Route::get('/empresa', function () {
    return view('empresa.index');
})->name('empresa.index');

// Rota para a página do PSE
Route::get('/pse', function () {
    return view('pse.index');
})->name('pse.index');

// Grupo de rotas que exigem autenticação (COMO O PERFIL) - BLOCO ATUALIZADO
Route::middleware('auth')->group(function () {
    // Rota para visualizar o perfil
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    // Rota para exibir o formulário de edição do perfil
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    // Rota para processar a atualização do perfil
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

// Mantenha as outras rotas, como as de autenticação, no final
require __DIR__.'/auth.php';
