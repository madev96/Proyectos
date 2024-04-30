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
        echo "
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-md-8'>
                    <div class='alert alert-warning text-center' role='alert'>
                        <h1>¡VEHÍCULO RETIRADO!</h1>
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

// Cerrar la conexión
$conn->close();
?>
