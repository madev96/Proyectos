<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        a{
            color: white;
        }
        a:hover{
            color:#d9d9d9;
        }
    </style>

</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/compras') }}">Compras</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/departamentos') }}">Departamentos</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/exportes') }}">Exportes</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/ventas') }}">Ventas</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/usuarios') }}">Usuarios</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url ('/perfil') }}">Información del usuario</a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/logout') }}">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap p-3 mb-3">
                    @yield('contenido')
                </div>
            </main>
        </div>
    </div>
    
</body>
</html>
