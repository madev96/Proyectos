<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ingresar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center" id="titulo-login">
            <div class="col-md-5 text-center">
                <h1>Ingreso al sistema</h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <form method="post" action="{{ url('/login') }}" class="form-group">
                    @csrf
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" autocomplete="email" required autofocus />

                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="current-password" required />

                    <button type="submit" class="btn btn-primary m-3">Ingresar</button>
                    
                    <button type="reset" class="btn btn-danger m-3">Limpiar campos</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
