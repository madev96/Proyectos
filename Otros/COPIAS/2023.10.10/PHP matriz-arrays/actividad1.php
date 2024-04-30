<?php
// Definición de variables
$usuario = "User 1";
$contrasena = 1234;

// Valores a comprobar
$usuario_input = "User 1";
$contrasena_input = 1234;

// Comprobar si el usuario y la contraseña son correctos
if ($usuario_input === $usuario && $contrasena_input === $contrasena) {
    echo "Genial, puedes pasar!!";
} elseif ($usuario_input === $usuario) {
    echo "Lo siento, el usuario es correcto, pero la contraseña no";
} elseif ($contrasena_input === $contrasena) {
    echo "Lo siento, este usuario no es válido";
} else {
    echo "No has acertado ninguna";
}
?>
