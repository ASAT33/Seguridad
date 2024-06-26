<?php

require_once('../class/functions.php');

$obj_funciones = new funciones();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula_cliente = $_POST['cedula_cliente'];
    $capital = $_POST['capital'];
    $interes = $_POST['interes'];
    $resultado_insert = $obj_funciones->insertar_pago($cedula_cliente, $capital, $interes);


    if ($resultado_insert) {

        header("Location: ../pago.php");
        exit();
    } else {
        echo "Error al ejecutar el procedimiento almacenado: ";
        header("Location: ../error_pago.php");
        exit();
    }
}
?>