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
            <li><a href="V_perfil.php">Mi perfil</a></li>
            <li><a href="V_catalogo.php">Catálogo</a></li>

            </ul>
        </nav>
    </header>
    <main>
    <div class="categories">
        <h2>Mi carrito</h2>
    </div>
    <!--Datos personales. -->
    <div class="categories">
    </div>
    </main>
</body>
</html>