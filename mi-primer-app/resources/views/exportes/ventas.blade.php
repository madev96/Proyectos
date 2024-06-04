@extends('layouts.exportarexcel')

@section('expcontent')

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
                <th scope="col">Usuario</th>
                <th scope="col">Departamento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
            <tr>
                <th scope="row">{{ $venta->id }}</th>
                <td>{{ $venta->cantidad }}</td>
                <td>{{ $venta->precio }}</td>
                <td>{{ $venta->user->name }}</td>
                <td>{{ $venta->user->departamento->nombre }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
