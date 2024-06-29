<?php
require_once('../class/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cedula = $_POST['id_cedula'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $id_cedula = str_replace("-", "", $id_cedula);

    $obj_funciones = new funciones();

    try {

        $registro_exitoso = $obj_funciones->registrar_cliente($id_cedula, $nombre, $telefono, $correo);

        if ($registro_exitoso) {

            header("Location: ../cliente.php");
            exit();
        } else {
            // Error en el registro
            header("Location: ../registro_cliente.php?error=2");
            exit();
        }
    } catch (mysqli_sql_exception $e) {

        if ($e->getCode() == 1062) {

            $mensaje_error = 'La cédula ingresada ya existe en la base de datos.';
        } else {

            $mensaje_error = 'Ha ocurrido un error inesperado.';
        }


        header("Location: ../registro_cliente.php?error=" . urlencode($mensaje_error));
        exit();
    }
} else {

    header("Location: ../registro_cliente.php");
    exit();
}
?>
