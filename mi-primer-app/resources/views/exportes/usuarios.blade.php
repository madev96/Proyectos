@extends('layouts.exportarexcel')

@section('expcontent')

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Departamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->departamento->nombre }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

@endsection
