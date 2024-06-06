<!-- Archivo: resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Registro en el sistema</title>
</head>
<body>
    <div class="row d-flex justify-content-center">
        <div class="col-md-5 text-center">
            <h1>Registro en el sistema</h1>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-5">
            <form method="post" action="{{ url('/register') }}" class="form-group">
                @csrf
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" autocomplete="name" required />

                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" autocomplete="email" required>

                <label for="departamento_id">Departamento</label>
                <select name="departamento_id" id="departamento_id" class="form-control" autocomplete="organization-title" required>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
                
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" required> 

                <label for="password_confirmation">Confirmar Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>

                <button type="submit" class="btn btn-primary mt-3">Registrar</button>
                
                <button type="reset" class="btn btn-danger mt-3">Limpiar campos</button>
            </form>
        </div>
    </div>
</body>
</html>
