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
                  

        <div class="categories">                                                   <!--  PRODUCTOS -->
            <h2>Administrar productos</h2>
        </div>

        <!-- AGREGAR PRODUCTO -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Agregar producto</summary> 
                    //El ID tiene que aparecer con la confirmación.  <br>
                    <br><br>
                    <div>
                        <form method="post">
                            <label for="casilla1">Nombre</label><br><br>
                            <input type="text" id="casilla1" name="casilla1" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ\s]{12,}"  title="Mínimo 12 caracteres (Solo letras, tildes y espacios)." required><br><br>
                            
                            <label for="casilla2">Descripción</label><br><br>
                            <textarea id="casilla2" name="casilla2" rows="6" cols="30" required>Manga ª Equipación oficial. Talla única.</textarea><br><br><br>
                            
                            <label for="casilla3">Precio</label><br><br>
                            <input type="text" id="casilla3" name="casilla3" pattern="^[0-9]+([,.][0-9]+)?$" title="Sólo se aceptan números. (Separar con un punto o una coma)" required>
                            <span>€</span>
                            <br><br>
                            
                            <input type="submit" value="OK">
                        </form>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Verificar si las variables están configuradas en $_POST
                            if (isset($_POST['casilla1'], $_POST['casilla2'], $_POST['casilla3'])) {
                                // Obtener los datos del formulario
                                $nombreProducto = $_POST['casilla1'];
                                $descripcion = $_POST['casilla2'];
                                $precio = $_POST['casilla3'];

                                // Reemplazar la coma por un punto en el precio antes de almacenarlo en la base de datos
                                $precioBD = str_replace(',', '.', $precio);

                                // Preparar la consulta SQL para insertar los datos en la tabla
                                $sql = "INSERT INTO productos (Nombre_Producto, Descripcion, Precio) VALUES ('$nombreProducto', '$descripcion', '$precioBD')";

                                // Ejecutar la consulta y verificar si fue exitosa
                                if ($enlace->query($sql) === TRUE) {
                                    echo "Se ha agregado el nuevo producto";
                                } else {
                                    echo "Error al guardar los datos: " . $enlace->error;
                                }
                            } else {
                                echo "No se han recibido todos los datos del formulario.";
                            }
                        }
                        ?>


                    </div>
                </details>
            </div>
        </div>
                
        <!-- EDITAR PRODUCTO -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Editar producto</summary>

                    <p>Sólo poder seleccionar prodcutos existentes(lista), y que aparezcan ¿todos? los datos<p>
                    <p>Revisar que si cambian otras tablas con estos cambios</p>    

                    <form  method="post">
                        <br>
                        <label for="edit-id">¿Qué producto deseas editar?</label><br><br>
                        <input type="text" id="edit-id" placeholder="Nombre actual" name="edit-id" required><br><br>

                        <label for="edit-nombre">Nuevo nombre:</label><br>
                        <input type="text" id="edit-nombre" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ\s]{12,}"  title="Mínimo 12 caracteres (Solo letras, tildes y espacios)." name="edit-nombre"><br><br>

                        <label for="edit-descripcion">Nueva descripción:</label><br>
                        <textarea id="edit-descripcion" name="edit-descripcion" rows="6" cols="30"></textarea><br><br>

                        <label for="edit-precio">Nuevo precio:</label><br>
                        <input type="text" id="edit-precio" pattern="^[0-9]+([,.][0-9]+)?$" title="Sólo se aceptan números. (Separar con un punto o una coma)" name="edit-precio">
                        <span>€</span><br><br>

                        <input type="submit" value="Guardar cambios">
                    </form>
                    <?php
        // Verificar si se ha enviado el formulario de edición
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['edit-id'], $_POST['edit-nombre'], $_POST['edit-descripcion'], $_POST['edit-precio'])) {
                $idProductoEditar = $_POST['edit-id'];
                $nuevoNombre = $_POST['edit-nombre'];
                $nuevaDescripcion = $_POST['edit-descripcion'];
                $nuevoPrecio = $_POST['edit-precio'];
        
                // Crear una consulta base sin incluir campos en blanco
                $sql = "UPDATE productos SET ";
                $updates = [];
        
                if (!empty($nuevoNombre)) {
                    $updates[] = "Nombre_Producto = '$nuevoNombre'";
                }
                if (!empty($nuevaDescripcion)) {
                    $updates[] = "Descripcion = '$nuevaDescripcion'";
                }
                if (!empty($nuevoPrecio)) {
                    // Reemplazar el punto por coma y agregar el símbolo de euro al final
                    $precioBD = number_format($nuevoPrecio, 2, ',', '') . ' €';
                    $updates[] = "Precio = '$precioBD'";
                }
                
        
                if (!empty($updates)) {
                    $sql .= implode(", ", $updates);
                    $sql .= " WHERE Nombre_Producto = '$idProductoEditar'";
        
                    // Ejecutar la consulta si hay campos para actualizar
                    if ($enlace->query($sql) === TRUE) {
                        echo "<br>";
                        $mensaje = " $idProductoEditar se ha actualizado. <br>";
                        echo "<br>";

                        $camposEditados = implode("<br><br> ", array_map(function ($campo) {
                            return ucwords(str_replace('_', ' ', $campo));
                        }, $updates));
                        $mensaje .= empty($camposEditados) ? "el producto" : "<br>$camposEditados<br> ";
                        
        
                        echo $mensaje;
                    } else {
                        echo "Error al actualizar el producto: " . $enlace->error;
                    }
                } else {
                    echo "No has completado ningún campo para editar el producto.";
                }
            } else {
                echo "No se han recibido todos los datos del formulario de edición.";
            }
        }
        ?>
        

                </details>
            </div>
        </div>
            
        <!-- ELIMINAR PRODUCTO -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Eliminar producto</summary>
                    <form method="post">
                        <label for="producto_a_eliminar"></label><br><br>
                        <input type="text" id="producto_a_eliminar" name="producto_a_eliminar" placeholder="Nombre del producto" required><br><br>
                        <input type="submit" value="Eliminar producto">
                    </form>

                    <?php
                    // Verificar si se ha enviado el formulario
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Verificar si el ID del producto a eliminar está configurado en $_POST
                        if (isset($_POST['producto_a_eliminar'])) {
                            // Obtener el ID del producto a eliminar y sanitizarlo para evitar inyección SQL
                            $idProductoEliminar = mysqli_real_escape_string($enlace, $_POST['producto_a_eliminar']);

                            // Preparar la consulta SQL para eliminar el producto
                            $sql = "DELETE FROM productos WHERE Nombre_Producto = '$idProductoEliminar'";

                            // Ejecutar la consulta y verificar si fue exitosa
                            if (mysqli_query($enlace, $sql)) {
                                
                            } else {
                                echo "Error al eliminar el producto: " . mysqli_error($enlace);
                            }
                        } else {
                            echo "No se ha recibido el nombre del producto a eliminar.";
                        }
                    }
                    ?>
                </details>
            </div>
        </div>


        <div class="categories">                                                  <!-- PEDIDOS -->
            <h2>Administrar pedidos</h2>
        </div>
        <!-- MARCAR COMPLETADO -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Marcar como completado</summary>
                    <form method="post">
                        <p>Hacer una lista de pedidos sin completar</p>
                        <br>
                        <label for="compPedido">Seleccione pedido:</label><br><br>
                        <input type="text" id="compPedido" placeholder="Nº de pedido" name="compPedido" required><br><br>
                        <label for="fechaEntrega">Fecha de entrega:</label><br><br>
                        <input type="datetime-local" id="fechaEntrega" name="fechaEntrega" required><br><br><br>
                        <input type="submit" value="Marcar">
                    </form>
                    <?php
// ... (código anterior)

// Sección para marcar un pedido como completado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['compPedido'], $_POST['fechaEntrega'])) {
    $pedido = $_POST['compPedido'];
    $fechaEntrega = $_POST['fechaEntrega'];
    
    // Escapar los datos para prevenir inyección SQL
    $pedido = mysqli_real_escape_string($enlace, $pedido);
    $fechaEntrega = mysqli_real_escape_string($enlace, $fechaEntrega);
    
    $sql = "UPDATE pedidos SET Fecha_Entrega = '$fechaEntrega' WHERE ID_Pedido = '$pedido'";
    
    if (mysqli_query($enlace, $sql)) {
        echo "Fecha de entrega actualizada exitosamente para el pedido Nº " . $pedido;
    } else {
        echo "Error al actualizar la fecha de entrega: " . mysqli_error($enlace);
    }
}
?>

                </details>
            </div>
        </div>
        <!-- ENVÍOS PENDIENTES -->      
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Ver pedidos pendientes</summary>
                    <?php
                    if (isset($_SESSION['email'])) {
                        $sql = "SELECT Pedidos.ID_Pedido, Pedidos.Fecha_Pedido, Clientes.ID_Cliente, Clientes.nombre AS Nombre_Cliente, Clientes.apellido AS Apellido_Cliente, Clientes.email AS Email_Cliente,
                        Detalles_Pedido.ID_Detalle, Detalles_Pedido.ID_Producto, Detalles_Pedido.Cantidad, Detalles_Pedido.Precio_Unitario, Detalles_Pedido.Subtotal,
                        Productos.Nombre_Producto
                        FROM Pedidos
                        INNER JOIN Detalles_Pedido ON Pedidos.ID_Pedido = Detalles_Pedido.ID_Pedido
                        INNER JOIN Productos ON Detalles_Pedido.ID_Producto = Productos.ID_Producto
                        INNER JOIN Clientes ON Pedidos.ID_Cliente = Clientes.ID_Cliente
                        WHERE Pedidos.Fecha_Entrega IS  NULL
                        ORDER BY Pedidos.ID_Pedido, Detalles_Pedido.ID_Detalle";
                        // Ordenar por ID_Pedido y ID_Detalle para agrupar

                        $result = mysqli_query($enlace, $sql);

                        if ($result) {
                            $currentPedido = null;

                            while ($mostrar = mysqli_fetch_array($result)) {
                                if ($currentPedido !== $mostrar['ID_Pedido']) {
                                    if ($currentPedido !== null) {
                                        // Cerrar la sección del pedido anterior
                                        echo "</div>"; // Cerrar el contenedor de los productos del pedido anterior
                                        echo "</div>"; // Cerrar el contenedor del pedido anterior
                                        echo "<br>";
                                    }

                                    // Iniciar la sección para el nuevo pedido
                                    echo "<div class='categories'>";
                                    echo "<div class='product'>";
                                    echo "<strong>Nº Pedido: </strong>" . $mostrar['ID_Pedido'] .  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Cliente: </strong>" . $mostrar['ID_Cliente'] . "<br><br><br>";
                                    echo "<strong>Nombre: </strong>" . $mostrar['Nombre_Cliente'] . " " . $mostrar['Apellido_Cliente'] . "<br><br>";
                                    echo "<strong>Email: </strong>" . $mostrar['Email_Cliente'] . "<br><br>";
                                    echo "<strong>Fecha pedido: </strong>" . $mostrar['Fecha_Pedido'] . "<br><br>";

                                    // Iniciar la sección para los productos del nuevo pedido
                                    echo "<div class='categories'>";
                                    $currentPedido = $mostrar['ID_Pedido'];
                                }

                                // Mostrar los detalles del pedido (productos)
                                echo "<div class='product'>";
                                echo $mostrar['ID_Detalle'] . "<br>";
                                echo "<strong>Producto: </strong>" . $mostrar['Nombre_Producto'] . "<br>";
                                echo "<strong>Cantidad: </strong>" . $mostrar['Cantidad'] . "<br>";
                                echo "<strong>Precio / unidad: </strong>" . $mostrar['Precio_Unitario'] . "<br>";
                                echo "<strong>Subtotal: </strong>" . $mostrar['Subtotal'] . "<br>";
                                echo "</div>";
                            }

                            // Cerrar la última sección del pedido
                            if ($currentPedido !== null) {
                                echo "</div>"; // Cerrar el contenedor de los productos del último pedido
                                echo "</div>"; // Cerrar el contenedor del último pedido
                                echo "<br>";
                            }
                        } else {
                            echo "Error en la consulta: " . mysqli_error($enlace);
                        }
                    } else {
                        echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
                    }
                    ?>
                </details>
            </div>
        </div>

        <!-- ENVÍOS COMPLETADOS -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Ver pedidos completados</summary>
                    <?php
                    if (isset($_SESSION['email'])) {
                        $sql = "SELECT Pedidos.ID_Pedido, Pedidos.Fecha_Pedido, Productos.Nombre_Producto, Clientes.ID_Cliente, Clientes.nombre AS Nombre_Cliente, Clientes.apellido AS Apellido_Cliente, Clientes.email AS Email_Cliente,
                        Detalles_Pedido.ID_Detalle, Detalles_Pedido.ID_Producto, Detalles_Pedido.Cantidad, Detalles_Pedido.Precio_Unitario, Detalles_Pedido.Subtotal
                    
                        FROM Pedidos
                        INNER JOIN Detalles_Pedido ON Pedidos.ID_Pedido = Detalles_Pedido.ID_Pedido
                        INNER JOIN Productos ON Detalles_Pedido.ID_Producto = Productos.ID_Producto
                        INNER JOIN Clientes ON Pedidos.ID_Cliente = Clientes.ID_Cliente
                        WHERE Pedidos.Fecha_Entrega IS NOT NULL

                        ORDER BY Pedidos.ID_Pedido, Detalles_Pedido.ID_Detalle";

                        $result = mysqli_query($enlace, $sql);

                        if ($result) {
                            $currentPedido = null;

                            while ($mostrar = mysqli_fetch_array($result)) {
                                if ($currentPedido !== $mostrar['ID_Pedido']) {
                                    if ($currentPedido !== null) {
                                        // Cerrar la sección del pedido anterior
                                        echo "</div>"; // Cerrar el contenedor de los productos del pedido anterior
                                        echo "</div>"; // Cerrar el contenedor del pedido anterior
                                        echo "<br>";
                                    }

                                    // Iniciar la sección para el nuevo pedido
                                    echo "<div class='categories'>";
                                    echo "<div class='product'>";
                                    echo "<strong>Nº Pedido: </strong>" . $mostrar['ID_Pedido'] .  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Cliente: </strong>" . $mostrar['ID_Cliente'] . "<br><br><br>";
                                    echo "<strong>Nombre: </strong>" . $mostrar['Nombre_Cliente'] . " " . $mostrar['Apellido_Cliente'] . "<br><br>";
                                    echo "<strong>Email: </strong>" . $mostrar['Email_Cliente'] . "<br><br>";
                                    echo "<strong>Fecha pedido: </strong>" . $mostrar['Fecha_Pedido'] . "<br><br>";

                                    // Iniciar la sección para los productos del nuevo pedido
                                    echo "<div class='categories'>";
                                    $currentPedido = $mostrar['ID_Pedido'];
                                }

                                // Mostrar los detalles del pedido (productos)
                                echo "<div class='product'>";
                                echo $mostrar['ID_Detalle'] . "<br>";
                                echo "<strong>Producto: </strong>" . $mostrar['Nombre_Producto'] . "<br>";
                                echo "<strong>Cantidad: </strong>" . $mostrar['Cantidad'] . "<br>";
                                echo "<strong>Precio / unidad: </strong>" . $mostrar['Precio_Unitario'] . "<br>";
                                echo "<strong>Subtotal: </strong>" . $mostrar['Subtotal'] . "<br>";
                                echo "</div>";
                            }

                            // Cerrar la última sección del pedido
                            if ($currentPedido !== null) {
                                echo "</div>"; // Cerrar el contenedor de los productos del último pedido
                                echo "</div>"; // Cerrar el contenedor del último pedido
                                echo "<br>";
                            }
                        } else {
                            echo "Error en la consulta: " . mysqli_error($enlace);
                        }
                    } else {
                        echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
                    }
                    ?>
                </details>
            </div>
        </div>
       

        <!-- USUARIOS -->                                                          <!--USUARIOS-->
        <div class="categories">
            <h2>Administrar usuarios</h2>
        </div>

      
        <!-- AÑADIR CLIENTE -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Añadir usuario</summary>
                    <br>
                    <form class="register-form" action="#" name="formularioEjemplo" method="post">
                        <input type="text" placeholder="Nombre" name="nombre" required>
                        <input type="text" placeholder="Apellido" name="apellido" required>
                        <input type="email" placeholder="Correo electrónico" name="email" required>
                        <input type="password" placeholder="Contraseña" name="contraseña" required>
                        <input type="password" placeholder="Confirmar contraseña" name="confirm_password" >
                        <input type="text" placeholder="Dirección" name="direccion">
                        <input type="text" placeholder="Ciudad" name="ciudad">
                        <input type="text" placeholder="Provincia" name="provincia">
                        <input type="text" placeholder="Código Postal" name="codigo_postal">
                        <br>
                        <label>
                            <input type="radio" name="tipo_usuario" value="admin" required> Administrador
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="tipo_usuario" value="cliente"> Cliente
                        </label>
                        <br>
                        <button name="registro" >Añadir</button>
                      
                    </form>
   
                    <?php
                        if (isset($_POST['registro'])) {
                            $nombre = $_POST['nombre'];
                            $apellido = $_POST['apellido'];
                            $email = $_POST['email'];
                            $contraseña = $_POST['contraseña'];
                            $direccion = $_POST['direccion'];
                            $ciudad = $_POST['ciudad'];
                            $provincia = $_POST['provincia'];
                            $codigo_postal = $_POST['codigo_postal'];

                            $tipo = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : ''; // Obtener el valor del radio button seleccionado

                            // Sentencia preparada para la inserción
                            $insertarDatos = mysqli_prepare($enlace, "INSERT INTO Clientes (nombre, apellido, email, contraseña, direccion, ciudad, provincia, codigo_postal, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                            // Vincular parámetros, incluyendo 'tipo' para la inserción
                            mysqli_stmt_bind_param($insertarDatos, "sssssssss", $nombre, $apellido, $email, $contraseña, $direccion, $ciudad, $provincia, $codigo_postal, $tipo);
                            
                            // Ejecutar la sentencia
                            $ejecutarInsertar = mysqli_stmt_execute($insertarDatos);

                            if ($ejecutarInsertar) {
                                echo '<script>alert("Usuario registrado correctamente");</script>';
                            
                            } else {
                                echo "Error al registrar: " . mysqli_error($enlace);
                            }

                            mysqli_stmt_close($insertarDatos);
                        }
                    ?>
                </details>
            </div>
        </div>

        <!-- Ver lista de clientes -->
        <div class="categories">
            <div class="product">
                <details>
                    <summary>Lista de usuarios</summary>
                    <?php
                        if (isset($_SESSION['email'])) {
                            $sql = "SELECT * FROM Clientes ";
                            $result = mysqli_query($enlace, $sql);

                            while($mostrar = mysqli_fetch_array($result)){
                                
                        ?>
                                <div class="categories">

                            <div class="product">
                                <?php echo "<strong>Nº Usuario: </strong> " . $mostrar['ID_Cliente']?><br><br>
                                <?php echo "<strong>Nombre:</strong>  " . $mostrar['nombre']?><br><br>
                                <?php echo "<strong>Apellidos:</strong>  " . $mostrar['apellido'] ?><br><br>
                                <?php echo "<strong>Email:</strong>  " . $mostrar['email'] ?><br><br>
                                <?php echo "<strong>Dirección:</strong>  " . $mostrar['direccion'] ?><br><br>
                                <?php echo "<strong>Ciudad:</strong>  " . $mostrar['ciudad'] ?><br><br>
                                <?php echo "<strong>Provincia:</strong>  " . $mostrar['provincia'] ?><br><br>
                                <?php echo "<strong>Código postal:</strong>  " . $mostrar['codigo_postal'] ?>
                                <br>
                            </div>
                            </div>

                        <?php
                            }
                        } else {
                            echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
                        }
                    ?>
                </details>
            </div>
        </div>


        <br><br><br><br><br>
    </main>
</body>
</html>
