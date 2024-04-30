<?php

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "maresp_bd";

    $enlace = mysqli_connect ($servidor, $usuario, $clave, $baseDeDatos);
    session_start(); // Iniciar la sesión para acceder a $_SESSION['email']

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <link rel="stylesheet" href="\Proyectos\Trabajo servidor\pro\vista\css\styles.css">  
    <script src="\Proyectos\Trabajo servidor\pro\vista\js\funcionalidades.js"></script>

    
</head>
<body>
<header>    
        <div class="top-bar">
            <div class="logo">
                <a href="V_catalogo.php">
                    <img src="\Proyectos\Trabajo servidor\pro\vista\img/logo.png" alt="Logo de la tienda">
                </a>
            </div>
           
        </div>
        
        <nav class="main-nav">
            <ul>
            <li><a href="V_catalogo.php">Catálogo</a></li>

                <li><a href="V_carrito.php">Mi carrito</a></li>
                <br>
                

            </ul>
        </nav>
    </header>
    <main>
    <div class="categories">
        <h2>Mi perfil</h2>
    </div>
    <!--Datos personales. -->
    <div class="categories">
        <!--Tabla de datos del usuario -->
   
        
        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido/s</td>
                <td>Correo</td>
                <td>Dirección</td>
                <td>Ciudad</td>
                <td>Provincia</td>
                <td>Codigo postal</td>
            </tr>
            <?php
                if (isset($_SESSION['email'])) {
                    // Consulta SQL para seleccionar datos del usuario actual basado en su email almacenado en $_SESSION['email']
                    $sql = "SELECT * FROM Clientes WHERE email = '" . $_SESSION['email'] . "'";
                    
                    // Ejecutar la consulta en la base de datos usando mysqli_query
                    $result = mysqli_query($enlace, $sql);

                    // Iterar sobre cada fila de resultados obtenidos

                while($mostrar=mysqli_fetch_array($result)){

            ?>


            <tr>
                <td><?php echo $mostrar['nombre'] ?></td>
                <td><?php echo $mostrar['apellido'] ?></td>
                <td><?php echo $mostrar['email'] ?></td>
                <td><?php echo $mostrar['direccion'] ?></td>
                <td><?php echo $mostrar['ciudad'] ?></td>
                <td><?php echo $mostrar['provincia'] ?></td>
                <td><?php echo $mostrar['codigo_postal'] ?></td>
            </tr>

        <?php
                }   } else {
                    echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
                }?>
        </table>
    </div>

    <!--Tabla de pedidos pendientes -->
    <br>
    <div class="categories">
        <h2>Mis pedidos pendientes.</h2>
    </div>
    <br>
    <!--Tabla de pedidos realizados -->
    <div class="categories">
        <h2>Mis pedidos realizados.</h2>
    </div>

    <!--Botón cerrar sesión--> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="categories">
        <form action="/Proyectos/Trabajo%20servidor/pro/controlador/C_cerrar_sesion.php" method="post"> 
            <input type="submit" value="Cerrar sesión">
        </form>
    </div>
    </main>
</body>
</html>