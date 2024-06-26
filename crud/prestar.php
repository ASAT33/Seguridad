<?php
require_once('../class/functions.php');



try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cedula_cliente = $_POST['cedula_cliente'];
        $cantidad_prestada = $_POST['cantidad_prestada'];
        $interes = $_POST['interes'];
        $plazo = $_POST['plazo'];
        
        $obj_funciones = new funciones();
        $resultado_insert = $obj_funciones->insertar_prestamo($cedula_cliente, $cantidad_prestada, $interes, $plazo);

        if ($resultado_insert) {
            header("Location: ../reporte.php");
            exit();
        } else {
            header("Location: ../error_registro_cliente.php");
            exit();
        }
    } else {

        header("Location: ../registro_cliente.php");
        exit();
    }
} catch (mysqli_sql_exception $e) {

    if ($e->getCode() == 1062) {
        $mensaje_error = "Ya existe un registro con la misma cédula.";
        header("Location: ../prestar.php?mensaje_error=" . urlencode($mensaje_error));
        exit();
    } else {
        $mensaje_error = "Debe crear un nuevo cliente para el prestamo.";
        header("Location: ../prestar.php?mensaje_error=" . urlencode($mensaje_error));
        exit();
    }
}
