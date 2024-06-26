<?php
require_once('class/navbar.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once('crud/pago_busca.php');
?>

<div class="container mt-5">
    <h1 class="mb-4">Registrar Pago</h1>
    <form action="crud/pago2.php" method="post" class="row">
        <div class="form-group col-md-3">
            <label for="cedula_cliente">Cédula del Cliente:</label>
            <input type="text" class="form-control" id="cedula_cliente" name="cedula_cliente" required>
        </div>

        <div class="form-group col-md-3">
            <label for="capital">Capital:</label>
            <input type="number" class="form-control" id="capital" name="capital" step="0.01" required>
        </div>

        <div class="form-group col-md-3">
            <label for="interes">Interés:</label>
            <input type="number" class="form-control" id="interes" name="interes" step="0.01" required>
        </div>

        <div class="col-md-3 mt-3">
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
        </div>
    </form>
    <h2 class="mt-5">Pagos</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline my-2 my-lg-0">
        <div class="row">
            <div class="col">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search">
            </div>
            <div class="col">
            <select class="form-control" name="search_field">
    <option value="cedula_cliente">Cedula</option>
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
                <th>Cedula</th>
                <th>Nombre Cliente</th>
                <th>Capital</th>
                <th>Interes</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pago as $pago) {
                echo "<tr>";
                echo "<td>{$pago['cedula_cliente']}</td>";
                echo "<td>{$pago['nombre_cliente']}</td>";
                echo "<td>{$pago['capital']}</td>";
                echo "<td>{$pago['interes']}</td>";
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

