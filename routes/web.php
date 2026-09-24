<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas web para sua aplicação.
|
*/

// Rota principal que carrega a view 'home'
Route::get('/', function () {
    return view('home');
});

// Mantenha as outras rotas, como as de autenticação, abaixo
require __DIR__.'/auth.php';
