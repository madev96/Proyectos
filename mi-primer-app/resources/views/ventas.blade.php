@extends('layouts.base')
@section('contenido')


<div class="container">
    <div class="row col-md-6">
        <form action="{{ url('/nueva-venta')}}" method="post">
            @csrf

            <label for="cantidad"
            class="form-label">Cantidad
            </label>
            <input type="number"
            class="form-control"
            name="cantidad"
            id="cantidad"
            placeholder="Ingrese la cantidad de artículos">

            @error('cantidad')
            <div class="alert alert-danger">{{ $messages }}</div>
            @enderror

            @if ($errors->has('cantidad'))
            <div class="alert alert-danger">
                {{ $errors->first('cantidad') }}
            </div>
        @endif
        

            <label for="precio"
            class="form-label">Precio
            </label>
            <input type="number"
            class="form-control"
            name="precio"
            id="precio"
            step="0.1"
            placeholder="Ingrese el precio">

            <label for="user_id"
            class="form-label">Usuario
            </label>
            <select name="user_id" id="user_id" class="form-control">
                <!-- como ya he traído todos los datos de la tabla (en el controllador(Venta.php) uso :all()) -->
                @foreach ($usuarios as $user)
                
                <option value="{{ $user->id}}">
                    {{$user->name }}
                </option>
                    
                @endforeach
            </select>

            <br>

            <button type="submit"
            class="btn btn-primary">
                Registrar venta
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
                @foreach ($ventas as $venta )
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
    </div>
    
</div>

@endsection
