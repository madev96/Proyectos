@extends('layouts.base')
@section('contenido')


<div class="container">
    <div class="row col-md-6">
        <form action="{{ url('/nuevo-departamento')}}" method="post">
            @csrf

            <label for="nombre"
            class="form-label">Nombre
            </label>
            <input type="text"
            class="form-control"
            name="nombre"
            placeholder="Ingrese el nombre del departamento">

            <br>

            <button type="submit"
            class="btn btn-primary">
                Registrar departamento
            </button>
        </form>
    </div>
</div>
<div class="container">
    <div class="row col-md-12"><!-- 12 me lo invento yo -->
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cant. de Usuarios</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departamentos as $departamento )
                <tr>
                    <th scope="row">{{ $departamento->id }}</th>
                    <td>{{ $departamento->nombre }}</td>
                    <td>{{ $departamento->user_count }}</td>
                </tr>
                @endforeach
            </tbody> 
        </table>
    </div>
</div>

@endsection
