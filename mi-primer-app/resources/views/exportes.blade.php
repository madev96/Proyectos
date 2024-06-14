@extends('layouts.base')
@section('contenido')
<div class="container">
    <div class="row">

        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Compras</h5>
                    <p class="card-text">
                        Desde el botón inferior exporte a CLS la tabla de compras</p>
                        <a href="{{ url('/exportar-compras') }}"
                        class="btn btn-primary">Exportar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ventas</h5>
                    <p class="card-text">
                        Desde el botón inferior exporte a CLS la tabla de ventas</p>
                        <a href="{{ url('/exportar-ventas') }}"
                        class="btn btn-primary">Exportar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">
                        Desde el botón inferior exporte a CLS la tabla de usuarios</p>
                        <a href="{{ url('/exportar-usuarios') }}"
                        class="btn btn-primary">Exportar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Departamentos</h5>
                    <p class="card-text">
                        Desde el botón inferior exporte a CLS la tabla de departamentos</p>
                        <a href="{{ url('/exportar-departamentos') }}"
                        class="btn btn-primary">Exportar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
