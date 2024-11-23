<?php

use Illuminate\Support\Facades\Route;

// Rota principal, direcionando para a página de lista de tarefas
Route::get('/', function () {
    return view('lista');
});
