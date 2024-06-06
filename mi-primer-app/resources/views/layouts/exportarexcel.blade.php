<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename="datos_exportados.xls"');
header('Pragma: no-cache');
header('Expires: 0');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        @yield('expcontent')
    </body>
    </html>