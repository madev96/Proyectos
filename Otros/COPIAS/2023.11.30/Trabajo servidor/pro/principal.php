<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en línea</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <header>    
        <div class="top-bar">
            <div class="logo">
                <img src="img/logo.png" alt="Logo de la tienda">
            </div>
           
          
        </div>
        <nav class="main-nav">
            <ul>
                <li>
                    <?php
                        session_start(); //se inicia la sesión.

                        // Accede a los datos de sesión
                        if(isset($_SESSION["email"])) {
                            echo '<a href="perfil.php">Mi perfil:</a> ' . $_SESSION["email"];
                        } else {
                            echo '<a href="perfil.php">Tu vacío:</a>';
                        }
                    ?>
                </li>
                <li><a href="#">Mi carrito</a></li>
                <br>
                <form action="cerrar_sesion.php" method="post">
                    <input type="submit" value="Cerrar sesión">
                </form>

            </ul>
        </nav>
    </header>

    <main>
        

    <section class="category-section">
    <h2>Catálogo</h2>
    <div class="categories">
        <div class="product">
            <img src="ruta_a_imagen_1.jpg" alt="Producto 1">
            <h3>Producto 1</h3>
            <p>Descripción del producto 1.</p>
            <p>Precio: $XX</p>
            <button>Agregar al carrito</button>
        </div>
        <!-- Repite esta estructura para cada producto -->
        <!-- Producto 2 -->
        <div class="product">
            <img src="ruta_a_imagen_2.jpg" alt="Producto 2">
            <h3>Producto 2</h3>
            <p>Descripción del producto 2.</p>
            <p>Precio: $XX</p>
            <button>Agregar al carrito</button>
        </div>
        <!-- Producto 3 -->
        <div class="product">
            <img src="ruta_a_imagen_3.jpg" alt="Producto 3">
            <h3>Producto 3</h3>
            <p>Descripción del producto 3.</p>
            <p>Precio: $XX</p>
            <button>Agregar al carrito</button>
        </div>
        <!-- ... y así sucesivamente hasta el producto 10 -->
        <!-- Producto 10 -->
        <div class="product">
            <img src="ruta_a_imagen_10.jpg" alt="Producto 10">
            <h3>Producto 10</h3>
            <p>Descripción del producto 10.</p>
            <p>Precio: $XX</p>
            <button>Agregar al carrito</button>
        </div>
    </div>
</section>

      
    </main>

 
</body>
</html>


