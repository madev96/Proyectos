@extends('layouts.base')
@section('contenido')


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Perfil del usuario</h2>
        </div>
    </div>
<div class="row">
    <div class="col-md-6">
        <div class="card" style="width:25rem;">
            <div class="card-body">
                <h3 class="card-title">{{ $user->name }} </h3>
                <p class="card-text">Email: {{ $user->email }}</p>
                <p class="card-text"> Departamento: {{$user->departamento->nombre }}</p>
                <p class="card-text"> Creación del perfil: {{$user->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
