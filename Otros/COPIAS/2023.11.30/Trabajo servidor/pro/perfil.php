<?php

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "maresp_bd";

    $enlace = mysqli_connect ($servidor, $usuario, $clave, $baseDeDatos);

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Mi perfil</title>
</head>
<body>


    <!--Tabla de datos del usuario -->
    <table>
        <tr>
            <td>Nombre</td>
            <td>Correo</td>
            <td>Dirección</td>
            <td>Ciudad</td>
            <td>Provincia</td>
            <td>Codigo postal</td>
         
        </tr>

        <?php
            $sql="SELECT * from user";
            $result=mysqli_query($enlace, $sql);

            while($mostrar=mysqli_fetch_array($result)){

        ?>


        <tr>
            <td><?php echo $mostrar['nombre'] ?></td>
            <td><?php echo $mostrar['correo'] ?></td>
            <td><?php echo $mostrar['direccion'] ?></td>
            <td><?php echo $mostrar['ciudad'] ?></td>
            <td><?php echo $mostrar['provincia'] ?></td>
            <td><?php echo $mostrar['codigo_postal'] ?></td>
        </tr>

        <?php
            }
            ?>
    </table>
    
</body>
</html>