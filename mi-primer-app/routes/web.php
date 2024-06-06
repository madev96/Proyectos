<?php

// Importamos las clases necesarias para este archivo.
use App\Http\Controllers\AdminController; // Controlador para manejar las solicitudes administrativas.
use App\Models\Compra; // Modelo que representa la tabla de compras en la base de datos.
use App\Models\User; // Modelo que representa la tabla de usuarios en la base de datos.
use App\Models\Departamento; // Modelo que representa la tabla de departamentos en la base de datos.
use App\Models\Venta; // Modelo que representa la tabla de ventas en la base de datos.
use Illuminate\Support\Facades\Route; // Facade para definir rutas en la aplicación.

// Agrupamos todas las rutas que requieren autenticación usando el middleware 'auth'.
// Esto significa que solo los usuarios autenticados podrán acceder a estas rutas.
Route::group(['middleware' => 'auth'], function () {

    // Definimos la ruta para la página de inicio.
    // Cuando el usuario visite la URL raíz ('/'), se cargará la vista 'welcome'.
    Route::get('/', function () {
        return view('welcome'); // Retorna la vista 'welcome'.
    });

    // Definimos la ruta para la página de ventas.
    // Cuando el usuario visite '/ventas', se ejecutará el método 'getVentas' del 'AdminController'.
    Route::get('/ventas', [AdminController::class, 'getVentas']);

    // Definimos la ruta para la página de compras.
    // Cuando el usuario visite '/compras', se ejecutará el método 'getCompras' del 'AdminController'.
    Route::get('/compras', [AdminController::class, 'getCompras']);

    // Definimos la ruta para la página de departamentos.
    // Cuando el usuario visite '/departamentos', se ejecutará el método 'getDepartamentos' del 'AdminController'.
    Route::get('/departamentos', [AdminController::class, 'getDepartamentos']);

    // Definimos la ruta para la página de usuarios.
    // Cuando el usuario visite '/usuarios', se ejecutará el método 'getUsuarios' del 'AdminController'.
    Route::get('/usuarios', [AdminController::class, 'getUsuarios']);

    // Definimos la ruta para la página de exportes.
    // Cuando el usuario visite '/exportes', se cargará la vista 'exportes'.
    Route::get('/exportes', function () {
        return view('exportes'); // Retorna la vista 'exportes'.
    });

    // Definimos la ruta para crear una nueva compra.
    // Cuando el usuario envíe un formulario a '/nueva-compra' (usando el método POST), se ejecutará el método 'nuevaCompra' del 'AdminController'.
    Route::post('/nueva-compra', [AdminController::class, 'nuevaCompra']);

    // Definimos la ruta para crear una nueva venta.
    // Cuando el usuario envíe un formulario a '/nueva-venta' (usando el método POST), se ejecutará el método 'nuevaVenta' del 'AdminController'.
    Route::post('/nueva-venta', [AdminController::class, 'nuevaVenta']);

    // Definimos la ruta para la página de perfil.
    // Cuando el usuario visite '/perfil', se cargará la vista 'perfil' con los datos del usuario autenticado.
    Route::get('/perfil', function () {
        $user = auth()->user(); // Obtiene los datos del usuario autenticado.
        return view('perfil', compact('user')); // Retorna la vista 'perfil' con los datos del usuario.
    });

    // Definimos la ruta para exportar las compras.
    // Cuando el usuario visite '/exportar-compras', se obtendrán todas las compras y se cargará la vista 'exportes.compras'.
    Route::get('/exportar-compras', function () {
        $compras = Compra::all(); // Obtiene todas las compras de la base de datos.
        return view('exportes.compras', compact('compras')); // Retorna la vista 'exportes.compras' con las compras.
    });

    // Definimos la ruta para exportar las ventas.
    // Cuando el usuario visite '/exportar-ventas', se obtendrán todas las ventas y se cargará la vista 'exportes.ventas'.
    Route::get('/exportar-ventas', function () {
        $ventas = Venta::all(); // Obtiene todas las ventas de la base de datos.
        return view('exportes.ventas', compact('ventas')); // Retorna la vista 'exportes.ventas' con las ventas.
    });

    // Definimos la ruta para exportar los usuarios.
    // Cuando el usuario visite '/exportar-usuarios', se obtendrán todos los usuarios y se cargará la vista 'exportes.usuarios'.
    Route::get('/exportar-usuarios', function () {
        $usuarios = User::all(); // Obtiene todos los usuarios de la base de datos.
        return view('exportes.usuarios', compact('usuarios')); // Retorna la vista 'exportes.usuarios' con los usuarios.
    });

    // Definimos la ruta para exportar los departamentos.
    // Cuando el usuario visite '/exportar-departamentos', se obtendrán todos los departamentos y se cargará la vista 'exportes.departamentos'.
    Route::get('/exportar-departamentos', function () {
        $departamentos = Departamento::all(); // Obtiene todos los departamentos de la base de datos.
        return view('exportes.departamentos', compact('departamentos')); // Retorna la vista 'exportes.departamentos' con los departamentos.
    });

});

// Incluimos el archivo de rutas de autenticación.
// Este archivo contiene las rutas necesarias para el registro, inicio de sesión y restablecimiento de contraseña.
require __DIR__.'/auth.php';
