<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
 
<div class="container mt-5 d-flex justify-content-center">
    <div class="formulario">
        <h1>Registro de Usuario</h1>
        <form action="./crud/registro.php" method="post">
            <div class="form-group">       
                <label for="id_cedula">ID Cedula:</label>
                <input type="text" class="form-control" id="id_cedula" name="id_cedula" pattern="/^\d{2}-\d{4}-\d{4}|\d{1}-\d{3}-\d{4}|\d{1}-\d{3}-\d{3}$/" title="Formato válido: xx-xxxx-xxxx" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="username">Correo:</label>
                <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Formato válido: usuario@dominio.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña (mínimo 8 caracteres):</label>
                <input type="password" class="form-control" id="password" name="password" pattern=".{8,}" title="La contraseña debe tener al menos 8 caracteres" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
        <?php
            define('ERROR_REGISTRO_GENERAL', 'Ha ocurrido un error general en el registro.');
            define('ERROR_DUPLICADO', 'La cédula o el nombre de usuario ya existen.');

            if (isset($_GET['error'])) {
                $mensaje_error = urldecode($_GET['error']);
                echo '<div class="alert alert-danger" role="alert">' . $mensaje_error . '</div>';
            }
            // \d{2}-\d{4}-\d{4}
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>