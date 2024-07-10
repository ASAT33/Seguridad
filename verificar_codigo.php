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
        <h1>Verificación de Código</h1> 
        <form action="./crud/verificar_codigo.php" method="post" class="text-center">
            <div class="form-group">
                <label for="verification_code">Código de Verificación:</label>
                <input type="text" class="form-control text-center" id="verification_code" name="verification_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Verificar</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
