<?php
    session_start(); //Se inicia la sesion
    //Se accede a los datos de sesión.
    echo "Esta es su sesión inciada " . $_SESSION["id"];

?>