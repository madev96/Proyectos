@extends('layouts.base')
@section('contenido')


<!-- formulario  para registrar nuevas compras asociadas a  un usuario s con cantidad, precio y usuario. -->

<div class="container">
    <div class="row col-md-6">
        <form action="{{ url('/nueva-compra')}}" method="post">
            @csrf

            <label for="cantidad"
            class="form-label">Cantidad
            </label>
            <input type="number"
            class="form-control"
            name="cantidad"
            placeholder="Ingrese la cantidad de artículos">

            <label for="precio"
            class="form-label">Precio
            </label>
            <input type="number"
            class="form-control"
            name="precio"
            step="0.1"
            placeholder="Ingrese el precio">

            <label for="user_id"
            class="form-label">Usuario
            </label>
            <select name="user_id" class="form-control">
                <!-- como ya he traído todos los datos de la tabla (en el controllador(Compra.php) uso :all()) -->
                @foreach ($usuarios as $user)
                
                <option value="{{ $user->id}}">
                    {{$user->name }}
                </option>
                    
                @endforeach
            </select>

            <br>

            <button type="submit"
            class="btn btn-primary">
                Registrar compra
            </button>
        </form>
    </div>
</div>
<div class="container">
    <div class="row col-md-12">
        <table class="table table-stripped">
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
                @foreach ($compras as $compra )
                <tr>
                    <th scope="row">{{ $compra->id }}</th>
                    <td>{{ $compra->cantidad }}</td>
                    <td>{{ $compra->precio }}</td>
                    <td>{{ $compra->user->name }}</td>
                    <td>{{ $compra->user->departamento->nombre }}</td>
                </tr>
                @endforeach
                    
        </table>
    </div>
</div>
@endsection
