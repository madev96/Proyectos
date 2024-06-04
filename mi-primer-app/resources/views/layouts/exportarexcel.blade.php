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
        @yield('expcontent')
    </body>
    </html>