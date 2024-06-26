<?php
require_once('class/functions.php');

$obj_funciones = new funciones();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $search_field = $_POST['search_field'];
    $allowed_fields = ['id_cedula', 'nombre'];

    if (!in_array($search_field, $allowed_fields)) {
        header("Location: ../error.php");
        exit();
    }

    $clientes = $obj_funciones->buscar_todo("cliente",$search, $search_field);
} else {
    $clientes = $obj_funciones->obtener_todo("clientes");
}
?>
