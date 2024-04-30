<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$clave = "root";
$baseDeDatos = "maresp_bd";

$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

if ($enlace->connect_error) {
    die("Error de conexión a la base de datos: " . $enlace->connect_error);
}

$sql = "SELECT * FROM productos";
$result = $enlace->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = [
            'id' => $row['ID_Producto'],
            'nombre' => $row['Nombre_Producto'],
            'descripcion' => $row['Descripcion'],
            'precio' => $row['Precio']
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarCarrito'])) {
    $emailUsuario = $_SESSION['email'] ?? '';

    if (!empty($emailUsuario)) {
        $query = "SELECT ID_Cliente FROM clientes WHERE email = '$emailUsuario'";
        $result = mysqli_query($enlace, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $idUsuario = $row['ID_Cliente'];
        }

        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];
        $precioUnitario = $_POST['precio'];

        $subtotal = $precioUnitario * $cantidad;

        $sqlInsert = "INSERT INTO detalles_pedido (ID_Producto, Cantidad, Precio_Unitario, ID_Cliente, Subtotal) 
                      VALUES ('$idProducto', '$cantidad', '$precioUnitario', '$idUsuario', '$subtotal')";

        if ($enlace->query($sqlInsert) === TRUE) {
            echo "Producto agregado al carrito con éxito";
        } else {
            echo "Error al agregar el producto al carrito: " . $enlace->error;
        }
    } else {
        echo "No se ha iniciado sesión o la variable de sesión 'email' no está configurada.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en línea</title>
    <link rel="stylesheet" href="css\styles.css">
    <script src="..\js\funcionalidades.js"></script>
    <script src="..\js\validarFormulario.js"></script>

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
                $enlace->close();
                ?>
                <br>
            </ul>
        </nav>
    </header>

    <main>
        <section class="category-section">
            <h2 id="catalogo">Catálogo</h2>
            <br>
            <div class="categories">
                <?php foreach ($productos as $producto) : ?>
                    <div class="product">
                        <h3><?php echo $producto['nombre']; ?></h3>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <p><?php echo number_format($producto['precio'], 2, ',', '.') . ' €'; ?></p><!--Para que salga con decimales -->
                        <form method="post" onsubmit="return validarFormulario(this);">
                            <input type="hidden" name="idProducto" value="<?php echo $producto['id']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                           
                            <div class="cantidad">
                                <input type="hidden" name="idCliente" value="<?php echo $idUsuario; ?>" ; ?>
                                <button type="button" class="disminuir">-</button>
                                <input type="text" class="cantidad-input" name="cantidad" value="0" readonly>
                                <button type="button" class="aumentar">+</button>
                            </div>
                            <div class="cantidad">
                                <input type="submit" name="agregarCarrito" value="Añadir al carrito">
                            </div>
                            
                        </form>
                        <div id="mensaje" style="display:none;"></div>

                    </div>
                <?php endforeach; ?>
            </div>
           
        </section>
    </main>
</body>

</html>