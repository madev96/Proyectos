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
    </body>
</html>