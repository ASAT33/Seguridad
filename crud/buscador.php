<?php
require_once('class/functions.php');

$obj_funciones = new funciones();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $search_field = $_POST['search_field'];
    $allowed_fields = ['id_prestamo', 'id_cedula', 'nombre_cliente'];

    if (!in_array($search_field, $allowed_fields)) {
        header("Location: ../error.php");
        exit();
    }

    $prestamos = $obj_funciones->buscar_todo("prestamos",$search, $search_field);
} else {
    $prestamos = $obj_funciones->obtener_todo("prestamos");
}
?>
