<?php
require_once('class/navbar.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once('crud/buscador.php');
?>

<div class="container mt-5">
    <h1 class="mt-5">Lista de Préstamos</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline my-2 my-lg-0">
        <div class="row">
            <div class="col">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search">
            </div>
            <div class="col">
                <select class="form-control" name="search_field">
                    <option value="id_prestamo">ID Préstamo</option>
                    <option value="id_cedula">Cedula</option>
                    <option value="nombre_cliente">Nombre Cliente</option>
                </select>
            </div>
            <div class="col">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </div>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>Cedula</th>
                <th>Nombre Cliente</th>
                <th>Cantidad Prestada</th>
                <th>Interés(%)</th>
                <th>Plazo(mes)</th>
                <th>Interés Calculado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($prestamos as $prestamo) {
                echo "<tr>";
                echo "<td>{$prestamo['id_prestamo']}</td>";
                echo "<td>{$prestamo['id_cedula']}</td>";
                echo "<td>{$prestamo['nombre_cliente']}</td>";
                echo "<td>{$prestamo['cantidad_prestada']}</td>";
                echo "<td>{$prestamo['interes']}</td>";
                echo "<td>{$prestamo['plazo']}</td>";
                echo "<td>{$prestamo['int_calculado']}</td>";
                echo "<td>";    
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
