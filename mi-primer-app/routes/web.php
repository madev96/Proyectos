
<?php

use App\Http\Controllers\AdminController;
use App\Models\Compra;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Venta;
use Illuminate\Support\Facades\Route;

// Agrupar rutas protegidas con el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    
    // Ruta para la página de inicio
    Route::get('/', function () {
        return view('welcome');
    });

    // Ruta para la vista de ventas
    Route::get('/ventas', [AdminController::class, 'getVentas']);

    // Ruta para la vista de compras
    Route::get('/compras', [AdminController::class, 'getCompras']);


    // Ruta para la vista de departamentos
    Route::get('/departamentos', [AdminController::class, 'getDepartamentos']);

    // Ruta para la vista de usuarios
    Route::get('/usuarios', [AdminController::class, 'getUsuarios']);

    // Ruta para la vista de exportes
    Route::get('/exportes', function () {
        return view('exportes');
    });

    // Ruta para las nuevas compras
    Route::post('/nueva-compra', [AdminController::class, 'nuevaCompra']);

        // Ruta para las nuevas ventas
    Route::post('/nueva-venta', [AdminController::class, 'nuevaVenta']);



    // Ruta para la vista de perfil
    Route::get('/perfil', function () {
        return view('perfil');
    });

   // ...
Route::get('/exportar-compras', function () {
    $compras = Compra::all();
    return view('exportes.compras', compact('compras'));
});

Route::get('/exportar-ventas', function () {
    $ventas = Venta::all();
    return view('exportes.ventas', compact('ventas'));
});

Route::get('/exportar-usuarios', function () {
    return view('exportes.usuarios');
});
Route::get('/exportar-departamentos', function () {
    return view('exportes.departamentos');
});
// ...


});

require __DIR__.'/auth.php';

