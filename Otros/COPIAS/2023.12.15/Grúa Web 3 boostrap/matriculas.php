<?php
   $matricula = $_GET['matricula'];
   if ($matricula  == '2024') {
    echo "El vehículo con matrícula: " . $matricula . "está en el depósito";
    } else {
        echo "Lo sentimos, el vehículo con matrícula: " . $matricula . " no está en el depósito";
    }
?>