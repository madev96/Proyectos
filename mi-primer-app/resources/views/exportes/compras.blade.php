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
                @foreach ($compras as $compra)
                <tr>
                    <th scope="row">{{ $compra->id }}</th>
                    <td>{{ $compra->cantidad }}</td>
                    <td>{{ $compra->precio }}</td>
                    <td>{{ $compra->user->name }}</td>
                    <td>{{ $compra->user->departamento->nombre }}</td>
                </tr>
                    
                @endforeach
            </tbody>
        </table>
@endsection
