<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root";
$password = "root";
$database = "grua";

// Verificar si se proporcionó una matrícula en la solicitud
if (isset($_GET['matricula']) && !empty($_GET['matricula']) && strlen($_GET['matricula']) >= 3 && strlen($_GET['matricula']) <= 9) {

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


date_default_timezone_set('Europe/Madrid');

// Obtener la matrícula de la consulta GET
$matricula = strtoupper($_GET['matricula']);

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
        <br><br>
        <div class='container  d-flex justify-content-center align-items-center'>
                <div class='col-md-8'>
                    <div class='alert alert-success text-center' role='alert'>
                        <br>
                        <h3>¡VEHÍCULO TRASLADADO!</h3>
                        <br>
                        <p>El vehículo con la matrícula <strong>$matricula</strong> ha sido movido por la grúa municipal con el único objetivo de garantizar el bienestar y la seguridad de Alcalá de Henares.</p>
                        <p>Este servicio es completamente gratuito y no implica ninguna multa de tráfico.</p>
                        <p>Para conocer el nuevo lugar de estacionamiento y los detalles del traslado, no dude en llamarnos.</p>
                        <button class='btn btn-primary'><a href='tel:918306814' style='color: inherit; text-decoration: none;'>Llamar ahora</a></button>
                        <br>

                    </div>
                </div>
        </div>
        ";
   
    } else {
        echo "
        <br><br>
        <div class='container  d-flex justify-content-center align-items-center'>
                <div class='col-md-8'>
                    <div class='alert alert-warning text-center' role='alert'>
                    <br>
                        <h3>¡VEHÍCULO RETIRADO!</h3>
                        <br>
                        <p>El vehículo con matrícula <strong>$matricula</strong> se encuentra en el depósito municipal.</p>
                        <br>
                        <p><strong>Para poder recuperarlo se requiere:</strong></p>
                        <ul class='list-unstyled'>
                            
                            <li>- Aportar la <a id='documentacion' href='#documentacion'>documentación necesaria</a>.</li>
                            <br>
                            <li>- Abonar la tasa en el depósito.</li>
                            
                            <small >(<em class=''>Sólo efectivo y/o tarjeta</em>)</small>
                            </ul>
                    </div>
                </div>
        </div>
        ";
        // Llamar a la función para calcular el precio de la tasa
        echo "<div class='container  d-flex justify-content-center align-items-center'>        ";
        echo "<div class='col-md-8'>";
        echo "<div class='alert alert-info text-center' role='alert'>";
        echo "<div class='precio'>";
        echo '<span style="font-size: larger;">' . calcularPrecioTasa($row) . '</span>';
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    // Matrícula no encontrada en la base de datos
    echo "
    <br><br>
    <div class='container  d-flex justify-content-center align-items-center'>
            <div class='col-md-6'>
                <div class='alert alert-danger text-center' role='alert'>
                <br>
                    <h3>Sin actuación de la grúa...</h3>
                    <br>
                    <p>Parece que la grúa municipal no ha intervenido con el vehículo: <strong>$matricula</strong>.</p>
                    <p>Por favor, verifique que la matrícula introducida sea correcta. Si no es así, por favor intente introducirla nuevamente.</p>
                    <p>Si su vehículo no está en el lugar de estacionaminento, no dude en contactarnos.</p>
                    <br>
                    <button class='btn btn-primary'><a href='tel:918306814' style='color: inherit; text-decoration: none;'>Llamar ahora</a></button>

                </div>
            </div>
    </div>
    ";
}
$conn->close();
} else {
    // Si no se proporciona una matrícula en la solicitud
   
    echo "
    <br><br>
    <div class='container  d-flex justify-content-center align-items-center'>
        <div class='col-md-6'>
            <div class='alert alert-warning text-center' role='alert'>
                <h3>¡Atención!</h3>
                <p>No se proporcionó una matrícula válida.</p>
                <p>Por favor, asegúrese de ingresar una matrícula y volver a intentarlo.</p>
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
    if ($tipoVehiculo == 'Moto') {
        if ($diffDias == 0 && $diffHoras <= 7) {
            // Dentro de las primeras 7 horas del primer día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio actualmente está aumentando 0,51€ cada hora desde la fecha de recogida. (Máximo primer día: 87,12€)</strong>
                                        <br><br>
                                        A partir del segundo día aumentará 3,63€ cada 24 horas.
                                        <br><br> 
                                        A partir de 30 días aumentará 25,77€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias == 0 && $diffHoras >= 8) {
            // Más de 8 horas del primer día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio hasta cumplir las primeras 24 horas no asciende más.</strong>
                                        <br><br> 
                                        A partir del segundo día aumentará 3,63€ cada 24 horas desde la fecha de recogida.
                                        <br><br> 
                                        A partir de 30 días, aumentará 25,77€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias <= 29) {
            // A partir del segundo día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio está aumentando 3,63€ cada 24 horas desde la fecha de recogida.</strong>
                                        <br><br> 
                                        A partir de 30 días aumentará 25,77€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias >= 30) {
            // A partir del día 30
            $mensajeDespuesEuro = "<strong>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</strong>
                                        <br><br>
                                        El precio está aumentando 25,77€ cada 24 horas desde la fecha de recogida.
                                        <br><br>";
        }
    } else {
        if ($diffDias == 0 && $diffHoras <= 7) {
            // Dentro de las primeras 7 horas del primer día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio actualmente está aumentando 1,63€ cada hora desde la fecha de recogida. (Máximo primer día: 196,75€)</strong>
                                        <br><br>
                                        A partir del segundo día aumentará 15,25€ cada 24 horas.
                                        <br><br> 
                                        A partir de 30 días aumentará 30,86€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias == 0 && $diffHoras >= 8) {
            // Más de 8 horas del primer día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio hasta cumplir las primeras 24 horas no asciende más.</strong>
                                        <br><br> 
                                        A partir del segundo día aumentará 15,25€ cada 24 horas desde la fecha de recogida.
                                        <br><br> 
                                        A partir de 30 días, aumentará 30,86€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias <= 29) {
            // A partir del segundo día
            $mensajeDespuesEuro = "<em>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</em>
                                        <br><br>
                                        <strong>El precio está aumentando 15,25€ cada 24 horas desde la fecha de recogida.</strong>
                                        <br><br> 
                                        A partir de 30 días aumentará 30,86€ cada 24 horas.
                                        <br><br>";
        } elseif ($diffDias >= 30) {
            // A partir del día 30
            $mensajeDespuesEuro = "<strong>Precio calculado para el día " . date('d/m/Y \a \l\a\s H:i') . " horas.</strong>
                                        <br><br>
                                        El precio está aumentando 30,86€ cada 24 horas desde la fecha de recogida.
                                        <br><br>";
        }
    }
    // Formatear el precio total con el mensaje de euro
    $precioTotalConMensaje = "<strong>" . number_format($precioTotal, 2, ',', '') . ' € </strong> <br><br>' . $mensajeDespuesEuro;
    return $precioTotalConMensaje;
    
}

