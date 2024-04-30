<?php
    $servidor = "localhost";
    $usuario = "root";
    $clave = "root";
    $baseDeDatos = "maresp_bd";

    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);
    session_start(); // Iniciar la sesión para acceder a $_SESSION['email']
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
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
        <div class="categories">
            <h2>Mi perfil</h2>
        </div>
        

        
        <!-- Datos personales -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary class="summaryPerfil">Datos personales</summary>
                    <br>
                    <?php
                    if (isset($_SESSION['email'])) {
                        $sql = "SELECT * FROM Clientes WHERE email = '" . $_SESSION['email'] . "'";
                        $result = mysqli_query($enlace, $sql);

                        while($mostrar = mysqli_fetch_array($result)){
                    ?>
                            <?php echo "<br>" . $mostrar['nombre']?>
                            <?php echo $mostrar['apellido'] ?><br><br>
                            <?php echo $mostrar['email'] ?><br><br>
                            <?php echo $mostrar['direccion'] ?><br><br>
                            <?php echo $mostrar['ciudad'] ?>
                            <?php echo $mostrar['provincia'] ?>
                            <?php echo $mostrar['codigo_postal'] ?><br><br><br>
                            <?php echo "<button>Editar mis datos</button>" ?>

                    <?php
                        }
                    } else {
                        echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
                    }
                    ?>
                </details>
            </div>
        </div>


        <!--  Pedidos pendientes -->
        <div class="categories">
            <div class="product">
                <details>
            <summary>Envíos pendientes</summary>
        
        <!-- Todo PHP para Pedidos pendientes -->
        <?php
        
            if (isset($_SESSION['email'])) {
                // Consulta SQL para obtener los pedidos pendientes
                $sql_pedidos_pendientes = "SELECT ID_Pedido FROM pedidos WHERE Fecha_Entrega IS NULL AND ID_Cliente = (SELECT ID_Cliente FROM Clientes WHERE email = '" . $_SESSION['email'] . "')";
                $result_pedidos_pendientes = mysqli_query($enlace, $sql_pedidos_pendientes);

                if ($result_pedidos_pendientes && mysqli_num_rows($result_pedidos_pendientes) > 0) {
                    while ($pedido_pendiente = mysqli_fetch_assoc($result_pedidos_pendientes)) {
                        $ID_Pedido = $pedido_pendiente['ID_Pedido'];

                        // Consulta para obtener los detalles de cada pedido pendiente de la tabla pedidos
                        $sql_detalles_pedido = "SELECT productos.Nombre_Producto, detalles_pedido.Cantidad, detalles_pedido.Precio_Unitario 
                                                FROM detalles_pedido 
                                                INNER JOIN productos ON detalles_pedido.ID_Producto = productos.ID_Producto 
                                                WHERE detalles_pedido.ID_Pedido = $ID_Pedido";
                        $result_detalles_pedido = mysqli_query($enlace, $sql_detalles_pedido);

                        // Variables para calcular el precio total del pedido
                        $precio_total_pedido = 0;
                        $cantidad_total_pedido = 0;

        ?>
        <!-- Estructura para cada pedido pendiente -->
        <div class="categories">
                <h3> Nº de pedido: (<?php echo $ID_Pedido; ?>/23 )</h3>
                
        </div>
        
        <div class="categories">
            
            <table class=tablaDatos>
                            
                            <?php
                            while ($detalle_pedido = mysqli_fetch_assoc($result_detalles_pedido)) {
                                $NombreProducto = $detalle_pedido['Nombre_Producto'];
                                $Cantidad = $detalle_pedido['Cantidad'];
                                $Precio_Unitario = $detalle_pedido['Precio_Unitario'];
                                $Subtotal = $Cantidad * $Precio_Unitario;

                                // Agregar el subtotal al precio total del pedido
                                $precio_total_pedido += $Subtotal;
                                $cantidad_total_pedido += $Cantidad;

                                ?>
                                <tr>
                                    <td><?php echo $Cantidad . " x &nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo $NombreProducto . "&nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo number_format($Precio_Unitario, 2, ',', '.') . " €/u  &nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo number_format($Subtotal, 2, ',', '.') . " €"; ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        
                        <!-- Mostrar el precio total del pedido -->
                    </div>
                    <div class='categories'>
                    <p><?php echo number_format($precio_total_pedido, 2, ',', '.'); ?> €</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <p>(<?php echo $cantidad_total_pedido; ?> artículos)</p>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='categories'><p>No tienes envíos pendientes.</p></div>";
            }
        }
        
        ?>
            </div>
        </div>
    </details>


    
        <!-- Pedidos realizados -->
        <div class="categories">
        <div class="product">
                <details>
            <summary>Pedidos completados</summary>
        
        <!-- Todo PHP para Pedidos pendientes -->
        <?php
        
            if (isset($_SESSION['email'])) {
                // Consulta SQL para obtener los pedidos pendientes
                $sql_pedidos_pendientes = "SELECT ID_Pedido FROM pedidos WHERE Fecha_Entrega IS NOT NULL AND ID_Cliente = (SELECT ID_Cliente FROM Clientes WHERE email = '" . $_SESSION['email'] . "')";
                $result_pedidos_pendientes = mysqli_query($enlace, $sql_pedidos_pendientes);

                if ($result_pedidos_pendientes && mysqli_num_rows($result_pedidos_pendientes) > 0) {
                    while ($pedido_pendiente = mysqli_fetch_assoc($result_pedidos_pendientes)) {
                        $ID_Pedido = $pedido_pendiente['ID_Pedido'];

                        // Consulta para obtener los detalles de cada pedido pendiente de la tabla pedidos
                        $sql_detalles_pedido = "SELECT productos.Nombre_Producto, detalles_pedido.Cantidad, detalles_pedido.Precio_Unitario 
                                                FROM detalles_pedido 
                                                INNER JOIN productos ON detalles_pedido.ID_Producto = productos.ID_Producto 
                                                WHERE detalles_pedido.ID_Pedido = $ID_Pedido";
                        $result_detalles_pedido = mysqli_query($enlace, $sql_detalles_pedido);

                        // Variables para calcular el precio total del pedido
                        $precio_total_pedido = 0;
                        $cantidad_total_pedido = 0;

        ?>
        <!-- Estructura para cada pedido pendiente -->
        <div class="categories">
                <h3> Nº de pedido: (<?php echo $ID_Pedido; ?>/23 )</h3>     
        </div>
        
        <div class="categories">
            <table class=tablaDatos>            
                            <?php
                            while ($detalle_pedido = mysqli_fetch_assoc($result_detalles_pedido)) {
                                $NombreProducto = $detalle_pedido['Nombre_Producto'];
                                $Cantidad = $detalle_pedido['Cantidad'];
                                $Precio_Unitario = $detalle_pedido['Precio_Unitario'];
                                $Subtotal = $Cantidad * $Precio_Unitario;

                                // Agregar el subtotal al precio total del pedido
                                $precio_total_pedido += $Subtotal;
                                $cantidad_total_pedido += $Cantidad;

                                ?>
                                <tr>
                                    <td><?php echo $Cantidad . " x &nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo $NombreProducto . "&nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo number_format($Precio_Unitario, 2, ',', '.') . " €/u  &nbsp;&nbsp;&nbsp;"; ?></td>
                                    <td><?php echo number_format($Subtotal, 2, ',', '.') . " €"; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        
                        <!-- Mostrar el precio total del pedido -->
                    </div>
                    <div class='categories'>
                    <p><?php echo number_format($precio_total_pedido, 2, ',', '.'); ?> €</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <p>(<?php echo $cantidad_total_pedido; ?> artículos)</p>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='categories'><p>Ningún pedido completado.</p></div>";
            }
        }
        
        ?>
            </div>
        </div>

        <!-- Botón cerrar sesión -->
        <div class="categories">
            <form action="../controlador/C_cerrar_sesion.php" method="post"> 
                <input type="submit" value="Cerrar sesión">
            </form>
            <br><br><br><br><br><br><br>
        </div>

    </main>
</body>
</html>
