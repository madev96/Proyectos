@extends('layouts.exportarexcel')

@section('expcontent')

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($departamentos as $departamento)
                <tr>
                    <th scope="row">{{ $departamento->id }}</th>
                    <td>{{ $departamento->nombre }}</td>
                </tr>
                    
                @endforeach
            </tbody>
        </table>
@endsection
