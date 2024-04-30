



<!--http://localhost/Proyectos/Gr%C3%BAa%20Web%202/index.html-->


<!DOCTYPE html>
<html lang="es">
<head>
    <title>Grúa Municipal - Alcalá</title>
    <meta charset="UTF-8">
    <meta name="description"content="Web de la grúa municipal de Alcalá de Henares"> <!--Esto tengo que mirarlo bien-->
    <meta name="ketwords" content="HTML, CSS, JavaScript">
    <!--Vincular el HTML CON EL ARCHIVO EXTERNO CON EL ARCHIVO ESTILOS CSS-->
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
    <!--Vincular el HTML CON EL ARCHIVO EXTERNO CON LA FUNCIONALIDAD JAVASCRIPT-->
    <script src="js/funcionalidad.js"></script>
    

</head>
<body>
    <button onclick="toggleDarkMode()">Modo Nocturno</button>

    <header>
        <div class="" id="divPoli">
            <a href="https://seguridadciudadana.ayto-alcaladehenares.es/policia-local/" target="_blank">
                <img id="imgPoli" src="img/poli.png" width="250px" height="65px">
            </a> 
         </div>
         <div class="" id="divAyto">
            <a href="https://www.ayto-alcaladehenares.es/" target="_blank">
            <img id="imgAyto" src="img/ayto3.png" width="200px" height="65px">
            </a> 
         </div>
        <a href="index.html"  class="encabezado">                                              
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

        <!--Resultado-->   
        <div class="divsPrincipales" id="resultado">
        <?php
        $matricula = $_GET['matricula'];
        if ($matricula == '2024') {
            echo "<br><h1>El vehículo con matrícula <strong>" . $matricula . "</strong> está en el depósito.</h1>";
        } else {
            echo "<br><h1>¡Ups...!<br><br> Parece que la grúa no ha actuado en los últimos 15 días con el vehículo: <strong>" . $matricula . "</strong><br><br><br>Para asegurarse, puede <a href='tel:+34918786844'>llamar al depósito.</a></h1>";
        }
        ?>
        <br><br>
        <a href="index.html#atencion"><button id="btnVolver"><h1>Volver</h1></button></a>
        <br><br>
</div>

    </main>
</body> 
<footer>
    <br>
    <!-- Desplegable de "Nuestros Servicios" -->
    <details>
        <summary><strong>Nuestros Servicios</strong></summary>
        <small>
            <br>
            <p class="suFoot">La Grúa Municipal de Alcalá de Henares es un servicio público que tiene como objetivo garantizar la seguridad vial y el cumplimiento de las normativas de tráfico en nuestra ciudad.</p>
            <br><br>
            <p class="suFoot">El servicio de la Grúa Municipal también se encarga de retirar los vehículos mal estacionados, abandonados o que obstaculizan el tráfico en las calles de Alcalá y de depositar los vehículos en nuestro depósito municipal, donde se garantiza la seguridad y custodia de los mismos.</p>
            <br><br>
            <p class="suFoot">De esta manera, se busca mejorar la fluidez del tráfico y garantizar la seguridad de peatones y conductores.</p>
        </small>
    </details>
    <br><br>
    <!-- Desplegable de "Nosotros" -->
    <details>
        <summary><strong>Sobre nosotros</strong></summary>
        <small >
            <br>
            <p class="suFoot">Nuestro equipo de profesionales altamente capacitados se esfuerza por brindar un servicio eficiente y de calidad a todos los ciudadanos, y estamos a su disposición las 24 horas del día, los 7 días de la semana. </p>
            <br><br>
            <p class="suFoot">Agradecemos su colaboración y compromiso en el cumplimiento de las normativas de tráfico y seguridad vial en nuestra ciudad.</p>
        </small>
    </details>
<br>
<hr>
<br>
<p id="SiNe"> Si necesita de nuestros servicios, no dude en contactar con la Policía Local. <br><br><a href="tel:092"> 092 </a> // <a href="tel:918306814"> 918306814 </a></p>
<br>
<p id="lastFooter">
    <small>&copy; 2023 Todos los derechos reservados. <a id="mlm" href="https://www.linkedin.com/in/manuel-lozano-mart%C3%ADnez-ab7160204/"><b>M.L</b></a></small>
</p>
</footer>
</html>