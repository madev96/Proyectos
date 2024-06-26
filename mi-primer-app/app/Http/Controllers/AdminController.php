<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Compra;
use App\Models\Departamento;
use App\Models\Venta;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{

    // Método para añadir nuevas compras
    public function nuevaCompra(Request $request)
    {
        //validar cantidad ni 0 ni menor
        $validatedData = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'], // Agregar validación para cantidad
            'user_id' => ['required', 'integer'],
            'precio' => ['required', 'numeric', 'min:0'],
        ]);
    
            
        $compra = new Compra();
        $compra->cantidad = $request->input('cantidad');
        $compra->user_id = $request->input('user_id');
        $compra->precio = $request->input('precio');
        $compra->save();

        $usuarios = User::all();
        $compras = Compra::all();

        return view('compras', compact('usuarios', 'compras'));
    }

    // Método para añadir nuevas ventas
    public function nuevaVenta(Request $request)
    {

        //validar cantidad ni 0 ni menor
        $validatedData = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'], // Agregar validación para cantidad
            'user_id' => ['required', 'integer'],
            'precio' => ['required', 'numeric', 'min:0'],
        ]);

        $venta = new Venta();
        $venta->cantidad = $request->input('cantidad');
        $venta->user_id = $request->input('user_id');
        $venta->precio = $request->input('precio');
        $venta->save();

        $usuarios = User::all();
        $ventas = Venta::all();

        return view('ventas', compact('usuarios', 'ventas'));
    }

    public function nuevoDepartamento(Request $request)
    {
        $departamento = new Departamento();
        $departamento->nombre = $request->input('nombre');
        $departamento->save();

        $usuarios = User::all();
        $departamentos = Departamento::withCount('user')->get();//

        return view('departamentos', compact('usuarios', 'departamentos'));
    }



    //método para mostrar usuarios
    public function getUsuarios() {
        $usuarios = User::all();

        return view('usuarios', compact('usuarios'));
     }
    //método para mostrar departamentos
     public function getDepartamentos(){
        $departamentos = Departamento::withCount('user')->get();

        return view('departamentos', compact('departamentos'));
    }
    // Obtener todas las compras y usuarios
    public function getCompras()
    {
        $usuarios = User::all();
        $compras = Compra::all();

        return view('compras', compact('usuarios', 'compras'));
    }
    //método para mostrar ventas
    public function getVentas() {
        $usuarios = User::all();
        $ventas = Venta::all();

        return view('ventas',  compact('usuarios', 'ventas'));
    }


}
   