<?php
require_once('class/functions.php');

$obj_funciones = new funciones();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $search_field = $_POST['search_field'];
    $allowed_fields = ['cedula_cliente', 'nombre_cliente']; 

    if (!in_array($search_field, $allowed_fields)) {
        header("Location: ../error.php");
        exit();
    }

    $pago = $obj_funciones->buscar_todo("pago", $search, $search_field);
} else {
    $pago = $obj_funciones->obtener_todo("pagos");
}

?>
