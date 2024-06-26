<?php
require_once('class/navbar.php');
session_start();

if (!isset($_SESSION['username'])) {

    header("Location: index.php");
    exit();
}
?>
<div class="container mt-5">
    <h1>Solicitud de Préstamo</h1>
    <form action="crud/prestar.php" method="post">
        <div class="form-group col-md-4">
            <label for="nombre_cliente">Cedula del Cliente:</label>
            <input type="text" class="form-control" id="cedula_cliente" name="cedula_cliente" required>
        </div>
        <div class="form-group col-md-4">
            <label for="cantidad_prestada">Cantidad Prestada:</label>
            <input type="number" class="form-control" id="cantidad_prestada" name="cantidad_prestada" required>
        </div>
        <div class="form-group col-md-4">
            <label for="interes">Interés (%):</label>
            <input type="number" class="form-control" id="interes" name="interes" required>
        </div>
        <div class="form-group col-md-4">
            <label for="plazo">Plazo (meses):</label>
            <input type="number" class="form-control" id="plazo" name="plazo" required>
        </div>
        <button type="submit" class="btn btn-primary">Solicitar Préstamo</button>
    </form>
    <?php
if (isset($_GET['mensaje_error'])) {
    $mensaje_error = urldecode($_GET['mensaje_error']);

}
if (isset($mensaje_error)) {
    echo '<div class="alert alert-danger alert-sm" role="alert">' . $mensaje_error . '</div>';
}

?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>




