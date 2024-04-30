<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Web de la grúa municipal de Alcalá de Henares">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <title>Grúa Municipal - Alcalá</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
    <script src="js/funcionalidad.js"></script>
</head>
<body>
    <button onclick="toggleDarkMode()">Modo Nocturno</button>

    <header>
        <div id="divPoli">
            <a href="https://seguridadciudadana.ayto-alcaladehenares.es/policia-local/" target="_blank">
                <img id="imgPoli" src="img/poli.png" width="250px" height="65px" alt="Policía Local de Alcalá de Henares">
            </a> 
        </div>
        <div id="divAyto">
            <a href="https://www.ayto-alcaladehenares.es/" target="_blank">
                <img id="imgAyto" src="img/ayto3.png" width="200px" height="65px" alt="Ayuntamiento de Alcalá de Henares">
            </a> 
        </div>
        <a href="index.html" class="encabezado">                                              
            <img class="grua" src="img/G2.png" alt="Link a la página de inicio Grúa Municipal de Alcalá de Henares">
        </a>
        <nav>   
            <div class="nav-container">
                <a class="nava" id="nt" href="tasas.html" >Tasas</a> 
                <a class="nava" id="nd" href="documentacion_necesaria.html" >Documentación</a> 
                <a class="nava" id="np" href="preguntas_frecuentes.html" >Preguntas</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="divsPrincipales" id="atencion">                                 
            <h2 id="spAtencion">
                <span>Atención
                    <a href="tel:+34918786844">telefónica</a>
                    y
                    <a href="index.html#mapa">presencial</a>
                    <span style="white-space: nowrap;">las 24 horas todos los días del año.</span>
                </span>
            </h2>  
        </div>

        <div class="divsPrincipales" id="resultado">
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
                    // Texto específico para el tipo de vehículo "Traslada"
                    echo "
                    <br>
                    <h1>¡Vehículo trasladado!</h1>
                    <br>
                    <p>El vehículo con la matrícula <strong>$matricula</strong> ha sido movido con éxito por la grúa municipal.</p>
                    <br>
                    <p>Queremos informarte que este servicio de grúa es completamente gratuito y no implica ninguna multa de tráfico.
                    <br>
                    <br>
                    Nuestro objetivo es garantizar el bienestar y la seguridad de Alcalá de Henares.</p>
                    <br>
                    <p>Para conocer el nuevo lugar de estacionamiento y los detalles del traslado, no dudes en contactarnos. Estamos aquí para ayudarte.</p>
                    <br>
                    <a href=\"tel:918306814\"> 918306814 </a>
                    <br><br><br>
                    ";
                    
                    
                } else {
                    echo "
                    <br>
                    <h1>¡Vehículo retirado!</h1>
                    <br>
                    <p>El vehículo con matrícula \"<strong>$matricula</strong>\" se encuentra en el depósito municipal.</p>
                    <br>
                    <p><strong>Para poder recuperarlo se requiere:</strong></p>
                    <p>- Identificación con DNI, NIE o similar.</p>
                    <p>- Aportar la <a href='documentacion_necesaria.html#malAparcamiento'>documentación necesaria</a>.</p>
                    <p>- Abonar el precio de la tasa actual: ";

                    // Aquí modificamos la llamada a la función calcularPrecioTasa() para pasar solo la fila correspondiente
                    $precioTasa = calcularPrecioTasa($row); // Pasamos $row como parámetro
                    echo $precioTasa . " €";

                    echo "<br><br></p>
                    <p>Asegúrese de cumplir con todos los requisitos antes de proceder a recuperar el vehículo.</p>";
                }
            } else {
                // Matrícula no encontrada en la base de datos
                echo "<br><h1>¡Sin movimientos...!</h1><br><br> Parece que el vehículo con matrícula <strong>" . $matricula . "</strong> no se encuentra en el depósito municipal.<br><br>Por favor, verifique la matrícula ingresada e inténtelo nuevamente.<br><br>";
                            echo "<form id='formconsultaVehiclo' name='formulario' method='get' action='matriculas.php#resultado'> 
                            <input id='matricula' placeholder='Matrícula' name='matricula' value='' type ='text'> <br><br>
                            <p>
                                <input id='comprobar' type='submit' value='Volver a comprobar' >
                            </p> 
                            <p>Asegúrese llamando a nuestro <a href='tel:+34918786844'>teléfono</a> o acudiendo al depósito en la dirección que se muestra más abajo.</p>
                        </form>";
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

                // Formatear el precio con dos decimales y coma como separador de miles
                return number_format($precioTotal, 2, ',', '');
            }


            // Cerrar la conexión
            $conn->close();
            ?>
        </div>

        <div class="divsPrincipales" id="mapa">                        
            <h2>¿Dónde está el depósito?</h2>
            <iframe id="maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3034.6118574306943!2d-3.386221424260664!3d40.48385115155189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42499f577e3769%3A0x7a62c38e5efb88ce!2sGr%C3%BAa%20Municipal%20de%20Alcal%C3%A1%20de%20Henares!5e0!3m2!1ses!2ses!4v1698426737985!5m2!1ses!2ses" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p id="dir"> <b>Dirección:</b> C/ Camino del Cementerio, S/N. 28806 Alcalá de Henares, Madrid</p>
            <a href="https://www.google.es/maps/place/Gr%C3%BAa+Municipal+de+Alcal%C3%A1+de+Henares/@40.4838512,-3.3862214,17z/data=!3m1!4b1!4m6!3m5!1s0xd42499f577e3769:0x7a62c38e5efb88ce!8m2!3d40.4838471!4d-3.3836465!16s%2Fg%2F11bwpz6ykd?entry=ttu" target="_blank">Ver en Google Maps</a>
        </div>
    </main>

    <footer>
        <details>
            <summary><strong>Nuestros Servicios</strong></summary>
            <small>
                <p class="suFoot">La Grúa Municipal de Alcalá de Henares es un servicio público que tiene como objetivo garantizar la seguridad vial y el cumplimiento de las normativas de tráfico en nuestra ciudad.</p>
                <p class="suFoot">El servicio de la Grúa Municipal también se encarga de retirar los vehículos mal estacionados, abandonados o que obstaculizan el tráfico en las calles de Alcalá y de depositar los vehículos en nuestro depósito municipal, donde se garantiza la seguridad y custodia de los mismos.</p>
                <p class="suFoot">De esta manera, se busca mejorar la fluidez del tráfico y garantizar la seguridad de peatones y conductores.</p>
            </small>
        </details>

        <details>
            <summary><strong>Sobre nosotros</strong></summary>
            <small>
                <p class="suFoot">Nuestro equipo de profesionales altamente capacitados se esfuerza por brindar un servicio eficiente y de calidad a todos los ciudadanos, y estamos a su disposición las 24 horas del día, los 7 días de la semana.</p>
                <p class="suFoot">Agradecemos su colaboración y compromiso en el cumplimiento de las normativas de tráfico y seguridad vial en nuestra ciudad.</p>
            </small>
        </details>

        <p id="SiNe"> Si necesita de nuestros servicios, no dude en contactar con la Policía Local. <br><a href="tel:092">092</a> // <a href="tel:918306814">918306814</a></p>

        <hr>

        <p id="lastFooter">
            <small>&copy; 2023 Todos los derechos reservados. <a id="mlm" href="https://www.linkedin.com/in/manuel-lozano-mart%C3%ADnez-ab7160204/"><b>M.L</b></a></small>
        </p>
    </footer>
</body>
</html>
