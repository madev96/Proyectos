<?php
$nombre = $_POST['nombre'];
session_start(); //se crea la sesión.
echo "Sesión iniciada".$nombre." <br> Bienvenido!";
$_SESSION["id"] = $nombre;
echo "Se ha creado una sesión con el nombre de usuario: ".$_SESSION["id"]."<br>";

?>

<a href="acceso2.php">Pincha aquí para acceder a la sesión iniciada</a>