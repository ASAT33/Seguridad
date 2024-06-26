<?php
require_once('class/navbar.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<body>
    <div class="container mt-5 text-center">
        <h1>Bienvenido al Sistema de Préstamos</h1>
        <p>En este sistema de Prestamo, puedes gestionar préstamos para clientes. Cada cliente puede tener como máximo un préstamo activo.</p>
        <p>Para comenzar, crea un nuevo cliente en la sección correspondiente. Una vez que tengas clientes registrados, podrás otorgarles préstamos.</p>
        <p>Gracias por utilizar este sistema. ¡Comencemos!</p>

        <a href="registro_cliente.php" class="btn btn-primary mt-3">Crear Nuevo Cliente</a>
        <a href="prestar.php" class="btn btn-success mt-3">Crear Nuevo Préstamo</a>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
