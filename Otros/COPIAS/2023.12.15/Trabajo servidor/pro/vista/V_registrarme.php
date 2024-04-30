<?php

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "maresp_bd";

    $enlace = mysqli_connect ($servidor, $usuario, $clave, $baseDeDatos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Maresp - Tienda Online</title>
    <link rel="stylesheet" href="\Proyectos\Trabajo servidor\pro\vista\css\styles.css">
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form class="register-form" action="#" name="formularioEjemplo" method="post">
            <input type="text" placeholder="Nombre" name="nombre" required>
            <input type="text" placeholder="Apellido" name="apellido" required>
            <input type="email" placeholder="Correo electrónico" name="email" required>
            <input type="password" placeholder="Contraseña" name="contraseña" required>
            <input type="password" placeholder="Confirmar contraseña" name="confirm_password" required>
            <input type="text" placeholder="Dirección" name="direccion">
            <input type="text" placeholder="Ciudad" name="ciudad">
            <input type="text" placeholder="Provincia" name="provincia">
            <input type="text" placeholder="Código Postal" name="codigo_postal">
            <button name="registro" >Registrarse</button>
        <div>
            <p class="login-link">¿Ya tienes una cuenta?</p>
            <a id="iniciaSesionAqui" href="index.html">Inicia sesión aquí</a>
        </div>  
    </div>
</body>

<?php

  if (isset($_POST['registro'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];
    $codigo_postal = $_POST['codigo_postal'];

    // Sentencia preparada para la inserción
    $insertarDatos = mysqli_prepare($enlace, "INSERT INTO Clientes (nombre, apellido, email, contraseña, direccion, ciudad, provincia, codigo_postal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Vincular parámetros
    mysqli_stmt_bind_param($insertarDatos, "ssssssss", $nombre, $apellido, $email, $contraseña, $direccion, $ciudad, $provincia, $codigo_postal);
    
    // Ejecutar la sentencia
    $ejecutarInsertar = mysqli_stmt_execute($insertarDatos);

    if ($ejecutarInsertar) {
        header("Location: index.html");

      
    } else {
        echo "Error al registrar: " . mysqli_error($enlace);
    }

    mysqli_stmt_close($insertarDatos);
}

    ?>

</html>
