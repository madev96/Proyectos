<?php
    $nombre = $_GET['nombre'];
    $matricula = $_GET['matricula'];
    if ($matricula  == '2024') {
    echo "Hola" . $nombre . ". El vehículo con matrícula: " . $matricula . "está en el depósito";
    } else if ($matricula == "4006") {
        echo "Lo sentimos " . $nombre . ". El vehículo con matrícula: " . $matricula . " no está en el depósito";
    } else {
        echo $nombre . ", esa matrícula me la suda, no es mía";
    }
?>