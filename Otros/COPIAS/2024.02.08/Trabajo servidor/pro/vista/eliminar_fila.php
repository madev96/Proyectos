<?php
$servidor = "localhost";
$usuario = "root";
$clave = "root";
$baseDeDatos = "maresp_bd";

// Establecer la conexión a la base de datos utilizando MySQLi
$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
if (!$enlace) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
// Verificar si se recibió un ID_Detalle válido
if (isset($_POST['ID_Detalle']) && !empty($_POST['ID_Detalle'])) {
    $ID_Detalle = $_POST['ID_Detalle'];

    // Realizar la eliminación en la base de datos
    $sql_delete = "DELETE FROM detalles_pedido WHERE ID_Detalle = $ID_Detalle";

    // Ejecutar la consulta de eliminación
    if ($enlace->query($sql_delete) === TRUE) {
        // Si se elimina correctamente, enviar una respuesta 200 (OK)
        http_response_code(200);
    } else {
        // Si hay un error, enviar una respuesta de error 500 (Error interno del servidor)
        http_response_code(500);
        echo "Error al eliminar el registro: " . $enlace->error;
    }
} else {
    // Si no se recibe un ID_Detalle válido, enviar una respuesta de error 400 (Solicitud incorrecta)
    http_response_code(400);
    echo "ID_Detalle no válido o no se proporcionó.";
}
?>
