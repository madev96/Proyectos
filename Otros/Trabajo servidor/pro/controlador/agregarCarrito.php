<?php
session_start();
include_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarCarrito'])) {
    $emailUsuario = $_SESSION['email'] ?? '';

    if (!empty($emailUsuario)) {
        // Obtener ID del usuario
        $query = "SELECT ID_Cliente FROM clientes WHERE email = '$emailUsuario'";
        $result = mysqli_query($enlace, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $idUsuario = $row['ID_Cliente'];
        }

        // Obtener detalles del producto a agregar al carrito
        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];
        $precioUnitario = $_POST['precio'];

        // Calcular subtotal
        $subtotal = $precioUnitario * $cantidad;

        // Insertar en la tabla detalles_pedido
        $sqlInsert = "INSERT INTO detalles_pedido (ID_Producto, Cantidad, Precio_Unitario, ID_Cliente, Subtotal) 
                      VALUES ('$idProducto', '$cantidad', '$precioUnitario', '$idUsuario', '$subtotal')";
        // Ejecutar la consulta
        mysqli_query($enlace, $sqlInsert);

    } else {
        echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
    }
}
?>
