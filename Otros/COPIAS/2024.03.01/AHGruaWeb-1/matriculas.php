<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root";
$password = "root";
$database = "grua";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la matrícula de la consulta GET
$matricula = $_GET['matricula'];

// Preparar y ejecutar la consulta SQL
$sql = "SELECT * FROM vehiculos WHERE matricula = '$matricula'";
$result = $conn->query($sql);

// Verificar si se encontró algún resultado
if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $fechaEntrada = new DateTime($row['fecha_entrada']);

    $tipoServicio = $row['tipo_servicio'];
    if ($tipoServicio == 'Traslado') {
        // Texto específico para el tipo de vehículo "Traslado"
        echo "
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-md-8'>
                    <div class='alert alert-success text-center' role='alert'>
                        <h1>¡VEHÍCULO TRASLADADO!</h1>
                        <p>El vehículo con la matrícula <strong>$matricula</strong> ha sido movido con éxito por la grúa municipal.</p>
                        <p>Queremos informarte que este servicio de grúa es completamente gratuito y no implica ninguna multa de tráfico.</p>
                        <p>Nuestro objetivo es garantizar el bienestar y la seguridad de Alcalá de Henares.</p>
                        <p>Para conocer el nuevo lugar de estacionamiento y los detalles del traslado, no dudes en contactarnos.</p>
                        <p><a href='tel:918306814'>918306814</a></p>
                    </div>
                </div>
            </div>
        </div>
        ";
    } else {
        echo "<br><br>";

        echo "
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-md-8'>
                    <div class='alert alert-warning text-center' role='alert'>
                        <h3>¡VEHÍCULO RETIRADO!</h3>
                        <p>El vehículo con matrícula <strong>$matricula</strong> se encuentra en el depósito municipal.</p>
                        <p><strong>Para poder recuperarlo se requiere:</strong></p>
                        <ul class='list-unstyled'>
                            <li>- Identificación con DNI, NIE o similar.</li>
                            <li>- Aportar la <a href='documentacion_necesaria.html#malAparcamiento'>documentación necesaria</a>.</li>
                            <li>- Abonar la tasa en el <a target='_blank' href='https://www.google.es/maps/place/Gr%C3%BAa+Municipal+de+Alcal%C3%A1+de+Henares/@40.4838512,-3.3862214,17z/data=!3m1!4b1!4m6!3m5!1s0xd42499f577e3769:0x7a62c38e5efb88ce!8m2!3d40.4838471!4d-3.3836465!16s%2Fg%2F11bwpz6ykd?entrX   y=ttu'>depósito</a>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        ";
        // Llamar a la función para calcular el precio de la tasa
        echo "<div class='container'>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='col-md-8'>";
        echo "<div class='alert alert-info text-center' role='alert'>";
        echo "<p><strong>Precio de la tasa:</strong></p>";
        echo "<div class='precio'>";
        echo calcularPrecioTasa($row);
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    // Matrícula no encontrada en la base de datos
    echo "
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <div class='alert alert-danger text-center' role='alert'>
                    <h1>¡SIN MOVIMIENTOS...!</h1>
                    <p>Parece que el vehículo con matrícula <strong>$matricula</strong> no se encuentra en el depósito municipal.</p>
                </div>
            </div>
        </div>
    </div>
    ";
}

// Función para calcular el precio de la tasa
function calcularPrecioTasa($result) {
    // Obtenemos la fila de la consulta
    $row = $result;
    $fechaEntrada = new DateTime($row['fecha_entrada']);
    // Fecha y hora actual
    $fechaActual = new DateTime();
    // Calculamos la diferencia de tiempo en segundos
    $diffTiempo = $fechaActual->getTimestamp() - $fechaEntrada->getTimestamp();

    // Calcular la diferencia de tiempo en días y horas
    $diffDias = floor($diffTiempo / (60 * 60 * 24)); // Convertimos a días
    $diffHoras = floor(($diffTiempo % (60 * 60 * 24)) / (60 * 60)); // Convertimos a horas

    // Calcular el precio basado en la diferencia de días y horas
    $precioPorDia = 183.86; // Precio base por día
    $precioPorHoraPrimero = 1.63; // Precio por hora durante las primeras 7 horas del primer día
    $precioPorHoraDespues = 15.25; // Precio por hora a partir del segundo día
    $precioTotal = 0;
    $primerDiaCompleto = 196.75;

    // Obtenemos el tipo de vehículo de la base de datos
    $tipoVehiculo = $row['tipo_vehiculo']; 

    // Verificar si el tipo de vehículo es una moto
    if ($tipoVehiculo == 'Moto') {
        // Aplicar precios especiales para motos
        $precioPorDia = 84.76; // Precio base por día para motos
        $precioPorHoraPrimero = 0.51; // Precio por hora durante las primeras 7 horas del primer día para motos
        $precioPorHoraDespues = 3.63; // Precio por hora a partir del segundo día para motos
        $primerDiaCompleto = 87.12; // Precio para el primer día completo para motos

        if ($diffDias == 0 && $diffHoras <= 7) {
            // Primer día y dentro de las primeras 7 horas
            $precioTotal = $precioPorDia + ($precioPorHoraPrimero * $diffHoras);
        } elseif ($diffDias == 0 && $diffHoras >= 8) {
            // Primer día con 8 horas o más.
            $precioTotal = $primerDiaCompleto;
        } elseif ($diffDias <= 29) {
            // A partir del segundo día
            $precioTotal = $primerDiaCompleto + ($precioPorHoraDespues * $diffDias);
        } elseif ($diffDias >= 30) {
            // A partir del día 30.
            $precioTotal = 192.39 + (($diffDias - 29) * 25.77);
        }
    } else {
        // Tipo de vehículo diferente de moto (suponiendo coche)
        if ($diffDias == 0 && $diffHoras <= 7) {
            // Primer día y dentro de las primeras 7 horas
            $precioTotal = $precioPorDia + ($precioPorHoraPrimero * $diffHoras);
        } elseif ($diffDias == 0 && $diffHoras >= 8) {
            // Primer día con 8 horas o más.
            $precioTotal = $primerDiaCompleto;
        } elseif ($diffDias <= 29) {
            // A partir del segundo día
            $precioTotal = $primerDiaCompleto + ($precioPorHoraDespues * $diffDias);
        } elseif ($diffDias >= 30) {
            // A partir del día 30.
            $precioTotal = 639 + (($diffDias - 29) * 30.86);
        }
    }

    // Generar el mensaje de euro y agregarlo al precio total
    $mensajeDespuesEuro = "";
    if ($diffDias == 0 && $diffHoras <= 7) {
        // Dentro de las primeras 7 horas del primer día
        $mensajeDespuesEuro = "<em>(Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " h.)</em>
                                    <br><br>
                                    <strong>El precio está aumentando 1,63 €/hora (Hasta el máximo: 196,75€)</strong>
                                    <br><br>
                                    A partir del segundo día aumenta 15,25 €/día.
                                    <br><br> 
                                    A partir de 30 días aumenta 30,86 €/día.";
    } elseif ($diffDias == 0 && $diffHoras >= 8) {
        // Más de 8 horas del primer día
        $mensajeDespuesEuro = "<em>(Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " h.)</em>
                                    <br><br>
                                    <strong>El precio hasta cumplir las primeras 24 horas no asciende más.</strong>
                                    <br><br> 
                                    A partir del segundo día aumenta 15,25 €/día.
                                    <br><br> 
                                    A partir de 30 días aumenta 30,86 €/día.";
    } elseif ($diffDias <= 29) {
        // A partir del segundo día
        $mensajeDespuesEuro = "<em>(Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " h.)</em>
                                    <br><br>
                                    <strong>El precio está aumentando 15,25 €/día.</strong>
                                    <br><br> 
                                    A partir de 30 días aumenta 30,86 €/día.";
    } elseif ($diffDias >= 30) {
        // A partir del día 30
        $mensajeDespuesEuro = "<strong>(Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " h.)</strong>
                                    <br><br>
                                    El precio está aumentando 30,86€ / día.";
    }
    
    // Formatear el precio total con el mensaje de euro
    $precioTotalConMensaje = "<strong>" . number_format($precioTotal, 2, ',', '') . ' € </strong> <br><br>' . $mensajeDespuesEuro;
    return $precioTotalConMensaje;
    
}
$conn->close();

// Cerrar la conexión

