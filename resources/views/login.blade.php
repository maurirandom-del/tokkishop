<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/ab7331ce45.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/loginstyles.css') }}">
</head>
<body class="login-body">
    <div class="wrapper">
        <form action="">
            <h1>Entrar</h1>
            <div class="input-box">
                <input type="text" placeholder="Usuario" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Contraseña" required>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Recordarme</label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn">Acceder</button>

            <div class="register-link">
                <p>¿No tienes cuenta? <a href="#">Registrate</a></p>
            </div>
        </form>        
    </div>
</body>
</html>