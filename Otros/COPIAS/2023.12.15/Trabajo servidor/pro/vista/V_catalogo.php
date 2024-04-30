<?php
session_start();
//Para cerar sesión despues de x segundos.
//Se indica el tiempo de actividad.
$tiempoInactivo= 1000;//segundos
//Si existe un valor para la clave time out, la sesión ha sido establecida y se procede con el cálculo restante.
if(isset($_SESSION["timeout"])){
    //Se calcula el tiemopo que ha transcurrido desde q se conectó.
    $sessionTTL = time()-$_SESSION["timeout"];
    //Si el tiempo de inactividad supera al establecido se cierra la sesión y se lanza un fichero PHP con una aviso.
    if($sessionTTL >$tiempoInactivo){
        session_destroy();
        header("Location: V_tiempoExcedido.html");
        exit();
    }
}
// Se almacena la hora exacta del inicio o creación de sesión.
$_SESSION["timeout"] = time();
// Array de productos (para CREAR nuevos productos)
$productos = [
    [
        'imagen' => 'ruta_a_imagen_1.jpg',
        'nombre' => 'Producto 1',
        'descripcion' => 'Descripción del producto 1.',
        'precio' => '10,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_2.jpg',
        'nombre' => 'Producto 2',
        'descripcion' => 'Descripción del producto 2.',
        'precio' => '11,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_3.jpg',
        'nombre' => 'Producto 3',
        'descripcion' => 'Descripción del producto 3.',
        'precio' => '15,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_4.jpg',
        'nombre' => 'Producto 4',
        'descripcion' => 'Descripción del producto 4.',
        'precio' => '16,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_5.jpg',
        'nombre' => 'Producto 5',
        'descripcion' => 'Descripción del producto 5.',
        'precio' => '11,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_6.jpg',
        'nombre' => 'Producto 6',
        'descripcion' => 'Descripción del producto 6.',
        'precio' => '10,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_7.jpg',
        'nombre' => 'Producto 7',
        'descripcion' => 'Descripción del producto 7.',
        'precio' => '12,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_8.jpg',
        'nombre' => 'Producto 8',
        'descripcion' => 'Descripción del producto 8.',
        'precio' => '15,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_9.jpg',
        'nombre' => 'Producto 9',
        'descripcion' => 'Descripción del producto 9.',
        'precio' => '12,00€'
    ],
    [
        'imagen' => 'ruta_a_imagen_10.jpg',
        'nombre' => 'Producto 10',
        'descripcion' => 'Descripción del producto 10.',
        'precio' => '13,00€'
    ],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en línea</title>
    <link rel="stylesheet" href="\Proyectos\Trabajo servidor\pro\vista\css\styles.css">  
    <script src="\Proyectos\Trabajo servidor\pro\vista\js\funcionalidades.js"></script>

    
</head>
<body>
    <header>    
        <div class="top-bar">
            <div class="logo">
                <img src="\Proyectos\Trabajo servidor\pro\vista\img/logo.png" alt="Logo de la tienda">
            </div>
           
        </div>
        
        <nav class="main-nav">
            <ul>
                <li>
                <li><a href="V_perfil.php">Mi perfil</a></li>
                <li><a href="V_carrito.php">Mi carrito</a></li>
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
            <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <h3><?php echo $producto['nombre']; ?></h3>
            <p><?php echo $producto['descripcion']; ?></p>
            <p>Precio: <?php echo $producto['precio']; ?></p>
            <div class="cantidad">
                <button class="aumentar">+</button>
                <input type="text" class="cantidad-input" value="0">
                <button class="disminuir">-</button>
            </div>
            <button>Agregar al carrito</button>
        </div>
    <?php endforeach; ?>
</div>


        </section>
        
    </main>
</body>
</html>


