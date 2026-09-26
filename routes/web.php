<?php

use Illuminate\Support\Facades\Route;

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


// Mantenha as outras rotas, como as de autenticação, abaixo
require __DIR__.'/auth.php';
