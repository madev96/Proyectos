<?php

use Illuminate\Support\Facades\Route;

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ventas', function () {
    return view('ventas');
});

Route::get('/compras', function () {
    return view('compras');
});

Route::get('/departamentos', function () {
    return view('departamentos');
});

Route::get('/usuarios', function () {
    return view('usuarios');
});

Route::get('/exportes', function () {
    return view('exportes');
});

Route::get('/perfil', function () {
    return view('perfil');
});



