<?php
    // Configuración de la conexión a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $clave = "root";
    $baseDeDatos = "maresp_bd";

    // Establecer la conexión a la base de datos utilizando MySQLi
    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
    session_start(); // Iniciar la sesión para acceder a $_SESSION['email']


    //AL COMPRAR, GUARDAR DATOS EN TABLA PEDIDOS
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {
        $emailUsuario = $_SESSION['email'] ?? '';
    
        if (!empty($emailUsuario)) {
            $query = "SELECT ID_Cliente FROM clientes WHERE email = '$emailUsuario'";
            $result = mysqli_query($enlace, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $idUsuario = $row['ID_Cliente'];
            }
    
            $idCliente = $idUsuario;
            $fecha = date("Y-m-d H:i:s"); // Obtiene la fecha y hora actual en un solo formato YYYY-MM-DD HH:MM:SS
           
           
            
          
            $sqlInsert = "INSERT INTO pedidos (ID_Cliente, Fecha_Pedido) 
                          VALUES ('$idCliente', '$fecha')";
    
           
        } else {
            echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
        }
        if ($enlace->query($sqlInsert) === TRUE) {
            // Obtener el ID_Pedido recién insertado
            $idPedido = mysqli_insert_id($enlace);
        
            // Asociar detalles del carrito con el ID_Pedido en la tabla detalles_pedido
            $sqlUpdateDetalles = "UPDATE detalles_pedido SET ID_Pedido = '$idPedido' WHERE ID_Cliente = '$idCliente' AND ID_Pedido IS NULL";
            if ($enlace->query($sqlUpdateDetalles) === TRUE) {
                echo "Compra realizada con éxito.";
            } else {
                echo "Error al asociar los detalles del pedido: " . $enlace->error;
            }
        } else {
            echo "Error al agregar el producto al carrito: " . $enlace->error;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <!-- Enlace a archivos CSS y JavaScript -->
    <link rel="stylesheet" href="css\styles.css">
    <script src="js\funcionalidades.js"></script>
</head>
<body>
<header>
        <div class="top-bar">
            <div class="logo">
                <a href="V_catalogo.php"> 
                    <img src="img/logo.png" alt="Logo de la tienda">
                </a>
            </div>
        </div>

        <nav class="main-nav">
            <ul>
                <li>
                <li><a href="V_perfil.php">Mi perfil</a></li>
                <li><a href="V_carrito.php">Mi carrito</a></li>
                <?php
                if (!empty($_SESSION['email'])) {
                    $query = "SELECT tipo FROM clientes WHERE email  = '" . $_SESSION['email'] . "'";
                    $result = mysqli_query($enlace, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $tipoUsuario = $row['tipo'];

                        if ($tipoUsuario === 'admin') {
                            echo '<li><a href="V_Administrar.php">Administrar</a></li>';
                        }
                    }
                }
                ?>
                <br>
            </ul>
        </nav>
    </header>
    <main>
        <!-- TÍTULO MI CARRITO -->
        <div class="categories">
            <h2>Mi carrito</h2>
        </div>

        <!-- PRODUCTOS EN CARRITO -->
        <div class="categories">
            <!-- Tabla productos en el carrito -->
            <table>
              
                <?php
                // Verificar la conexión a la base de datos
                if ($enlace->connect_error) {
                    die("Error de conexión a la base de datos: " . $enlace->connect_error);
                }
                
                if (isset($_SESSION['email'])) {
                    // Consulta para obtener los detalles del carrito del usuario
                    $sql = "SELECT productos.Nombre_Producto, productos.ID_Producto, detalles_pedido.Cantidad, detalles_pedido.Precio_Unitario, detalles_pedido.Subtotal, detalles_pedido.ID_Detalle
                    FROM detalles_pedido
                    INNER JOIN clientes ON detalles_pedido.ID_Cliente = clientes.ID_Cliente
                    INNER JOIN productos ON detalles_pedido.ID_Producto = productos.ID_Producto
                    WHERE clientes.email = '" . $_SESSION['email'] . "'
                    AND detalles_pedido.ID_Pedido IS NULL"; // Agregamos esta condición para filtrar las filas con ID_Pedido nulo
            
                    
                    $result = mysqli_query($enlace, $sql);
                    $totalCantidad = 0;
                    $totalSubtotal = 0;
                

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($mostrar = mysqli_fetch_assoc($result)) {
                            // Obtener los detalles de los productos y calcular totales
                            
                            $ID_Detalle = $mostrar['ID_Detalle'];
                            $cantidad = $mostrar['Cantidad'];
                            $precioUnitario = number_format($mostrar['Precio_Unitario'], 2, ',', '.'); // Formatear con coma como separador decimal
                            $subtotal = number_format($mostrar['Subtotal'], 2, ',', '.'); // Formatear con coma como separador decimal
                            $nombrePro = $mostrar['Nombre_Producto'];

                            $totalCantidad += $cantidad;
                            $totalSubtotal += $mostrar['Subtotal']; // Mantener el subtotal sin formatear para cálculos posteriores

                            ?>
                            <!-- Mostrar detalles de productos en la tabla -->
                            <tr>
                                <td><?php echo $nombrePro . " &nbsp;&nbsp;&nbsp;"; ?></td>
                                <td><?php echo $cantidad. " x &nbsp;&nbsp;&nbsp;"; ?></td>
                                <td><?php echo $precioUnitario ." €/u  &nbsp;&nbsp;&nbsp;"; ?></td>
                                <td><?php echo $subtotal . " € &nbsp;&nbsp;&nbsp"; ?></td>
                                <td >
                                    <button  onclick="eliminarFila(<?php echo $ID_Detalle; ?>)">x</button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tu carrito está vacío de momento.</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
        
        <!-- RESUMEN ARTÍCULOS Y PRECIO -->
        <div class="resumen">
            <div class="categories">
                <h3><?php echo $totalCantidad; ?> artículos.</h3>
            </div>
            <div class="categories">
            <h3>Precio: <?php echo number_format($totalSubtotal, 2, ',', '.'); ?> €</h3>
            </div>
            <div class="categories">
                <!-- Botón para comprar -->
                <form method="post">
                    <input type="submit" name="comprar" value="Comprar">
                </form>
            </div>
        </div>

        <br><br><br><br><br><br><br><br><br><br><br>


        <!--FUNCIÓN BOTÓN ELIMINAR FILAS-->
        <script>
        function eliminarFila(ID_Detalle) {
            if (confirm('¿Estás seguro de eliminar este artículo?')) {
                // Crear una instancia de objeto XMLHttpRequest
                var xhttp = new XMLHttpRequest();
                
                // Definir la función a ejecutar cuando la solicitud esté completa
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Actualizar la página o realizar alguna acción adicional si es necesario
                        location.reload(); // Recargar la página después de eliminar la fila
                    }
                };
                
                // Enviar una solicitud POST al servidor
                xhttp.open("POST", "eliminar_fila.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("ID_Detalle=" + ID_Detalle);
            }
        }
        </script>
    </main>
</body>
</html>
