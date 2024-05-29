@extends('layouts.base')
@section('contenido')


<h1>Usuarios del sistema</h1>

<!--Tabla de usuarios-->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Email</th>
            <th scope="col">Departamento</th>
            <th scope="col">Ventas</th>
            <th scope="col">Compras</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Santiago</td>
            <td>Aguirre</td>
            <td>santiago@gamil.com</td>
            <td>Deportes</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Micaela</td>
            <td>Aguirre</td>
            <td>micaela@gamil.com</td>
            <td>Textil</td>
            <td>1</td>
            <td>3</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Pablo</td>
            <td>López</td>
            <td>pablo@gamil.com</td>
            <td>Informática</td>
            <td>5</td>
            <td>9</td>
        </tr>
    </tbody>
</table>

<!--Formulario nuevos usuarios
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Crear nuevo usuario</h3>
            <form action="" method="">

                <label for="" class="form-label">Email</label>
                <input type="email"
                class="form-control" name=""
                placeholder="Ingrese el email">

                <label for="" class="form-label">Nombre</label>
                <input type="text"
                class="form-control" name=""
                placeholder="Nombre">

                <label for="" class="form-label">Apellido</label>
                <input type="text"
                class="form-control" name=""
                placeholder="Apellido">

                <label for="" class="form-label">Departamento</label>

                <select name="departamento"
                class="form-control">
                    <option value="Textil">
                        Textil
                    </option>
                    <option value="Deportes">
                        Deportes
                    </option>
                    <option value="Informática">
                        Informática
                    </option>
                </select>
                
                <label for="" class="form-label">Password</label>
                <input type="password"
                class="form-control  mb-3" name="" placeholder="Ingrese la contraseña">  mb-3 lo pongo yo para que separa del botón de abajo 

                <button type="submit"
                class="btn btn-primary">Crear Usuario
                </button>
            </form>
        </div>
    </div>
</div>
-->

@endsection
