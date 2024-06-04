<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename="participantes.xls"');
header('Pragma: no-cache');
header('Expires: 0');
?><!-- esto creo que se elimina -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <table class="table">
            <thead>
                <tr>
                    <th scope="row">{{ $compra->id }}</th>
                    <th scope="col">ID</th>
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
    </body>
</html>