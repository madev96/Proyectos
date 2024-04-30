<?php

//CONTIENE LA LÓGICA PARA AUTENTICAR UN USUARIO.

session_start();
include_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEmail = $_POST['email'];
    $password = $_POST['contraseña'];
    $consulta = "SELECT * FROM Clientes WHERE email = '$idEmail' AND contraseña = '$password'";
    $resultado = mysqli_query($enlace, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $_SESSION['email'] = $idEmail;
        header("Location: ../vista/V_catalogo.php");
        exit();
    } else {
        header("Location: ../index.html?error=credenciales");
        exit();
    }
}
?>
