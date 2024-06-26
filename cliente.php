<?php
require_once('class/navbar.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once('crud/buscador_cli.php');
?>

<div class="container mt-5">
    <h1 class="mt-5">Clientes</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline my-2 my-lg-0">
        <div class="row">
            <div class="col">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search">
            </div>
            <div class="col">
                <select class="form-control" name="search_field">
                    <option value="id_cedula">Cedula</option>
                    <option value="nombre">Nombre Cliente</option>
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
                <th>Telefono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clientes as $clientes) {
                echo "<tr>";
                echo "<td>{$clientes['id_cedula']}</td>";
                echo "<td>{$clientes['nombre']}</td>";
                echo "<td>{$clientes['telefono']}</td>";
                echo "<td>{$clientes['correo']}</td>";
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
