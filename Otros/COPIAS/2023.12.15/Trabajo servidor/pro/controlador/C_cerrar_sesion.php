<?php
    session_start();
    session_destroy();
    header("Location: /Proyectos/Trabajo%20servidor/pro/vista/index.html");
?>