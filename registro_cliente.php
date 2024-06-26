<?php
require_once('class/navbar.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-4">
    <h1>Registro de Cliente</h1>
    <form action="crud/registrar_cliente.php" method="post">
        <div class="form-group col-md-4">
            <label for="id_cedula">ID Cedula:</label>
            <input type="text" class="form-control" id="id_cedula" name="id_cedula" pattern="\d{1,2}-\d{1,4}-\d{1,4}" title="Formato válido: xx-xxxx-xxxx" required>
        </div>
        <div class="form-group col-md-4">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group col-md-4">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group col-md-4">
            <label for="correo">Correo:</label>
            <input type="text" class="form-control" id="correo" name="correo" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
    </form>
    <?php
    if (isset($_GET['error'])) {
        $error_message = urldecode($_GET['error']);
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>
