<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        /* Selector más específicos (que "a" ) para los enlaces en la barra lateral */
        .nav-link {
            color: white;
        }
        .nav-link:hover {
            color: #d9d9d9;
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
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/compras') }}">
                                <i class="fas fa-shopping-cart"></i> Compras
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/departamentos') }}">
                                <i class="fas fa-building"></i> Departamentos
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/exportes') }}">
                                <i class="fas fa-shipping-fast"></i> Exportes
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/ventas') }}">
                                <i class="fas fa-chart-line"></i> Ventas
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/usuarios') }}">                            
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                        </li>
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ url('/perfil') }}">
                                <i class="fas fa-user-circle"></i> Información del usuario
                            </a>
                        </li>
                        <li class="nav-item p-4 mt-auto">
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-light" href="{{ url('/logout') }}">Cerrar sesión</a>
                            </div>
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
