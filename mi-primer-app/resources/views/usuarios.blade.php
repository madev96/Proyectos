@extends('layouts.base')

@section('contenido')

<div class="container">
    <div class="row col-md-12">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Número de Ventas</th>
                    <th scope="col">Número de Compras</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                <tr>
                    <th scope="row">{{ $usuario->id }}</th>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->departamento->nombre }}</td>
                    <td>{{ $usuario->ventas->count() }}</td>
                    <td>{{ $usuario->compras->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
