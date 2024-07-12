<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Iniciar Sesión</title>
</head>
<body>

<div class="container mt-5 d-flex justify-content-center">
    <div class="formulario">
        <h1>Bienvenido</h1> 
        <form action="./crud/login.php" method="post" class="text-center">
            <div class="form-group">
                <label for="username">Cédula:</label>
                <input type="text" class="form-control text-center" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control text-center" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="register.php" class="btn btn-secondary mt-3">Registrarse</a>
        </form>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == '1') {
                echo '<div class="alert alert-danger" role="alert">Credenciales incorrectas. Por favor, inténtalo de nuevo.</div>';
            } elseif ($_GET['error'] == 'limite_superado') {
                echo '<div class="alert alert-warning" role="alert">Límite de intentos superado. Intenta de nuevo después de 15 minutos.</div>';
            }
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
