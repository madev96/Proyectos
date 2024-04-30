<?php
    // Establecer la conexión a la base de datos
    $servidor = "localhost"; // Dirección del servidor de la base de datos
    $usuario = "root"; // Usuario de la base de datos
    $clave = "root"; // Contraseña de la base de datos
    $baseDeDatos = "maresp_bd"; // Nombre de la base de datos

    // Conexión a la base de datos usando mysqli
    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

    // Obtener los valores del formulario de inicio de sesión
    $idEmail = $_POST['email']; // Obtener el email enviado desde el formulario
    $password = $_POST['contraseña']; // Obtener la contraseña enviada desde el formulario

    // Construir la consulta para verificar las credenciales
    $consulta = "SELECT * FROM Clientes WHERE email = '$idEmail' AND contraseña = '$password'";

    // Ejecutar la consulta en la base de datos
    $resultado = mysqli_query($enlace, $consulta);

    // Iniciar la sesión
    session_start();

    // Verificar si se encontró exactamente una fila que coincide con las credenciales proporcionadas
    if (mysqli_num_rows($resultado) == 1) {
        // Si se encontró una fila, iniciar sesión y almacenar el email en la sesión
        $_SESSION['email'] = $idEmail; // Almacenar el email en la sesión
        // Redirigir al usuario a la página catálogo después de iniciar sesión correctamente
        header("Location: ../vista/V_catalogo.php");
        exit(); // Finalizar el script para evitar que se ejecute más código después de la redirección
    } else {
        // Si no se encontró una fila que coincida con las credenciales, mostrar un mensaje de error
        // Si no se encontró una fila que coincida con las credenciales, redirigir a index.html con un parámetro de error
        header("Location: ../index.html?error=credenciales");
        exit(); // Finalizar el script para evitar que se ejecute más código después de la redirección

    }
?>
