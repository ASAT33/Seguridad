<?php
require_once('../class/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cedula = $_POST['id_cedula'];
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $obj_funciones = new funciones();
    
    try {
  
        $registro_exitoso = $obj_funciones->registrar_usuario($id_cedula, $nombre, $username, $password);

        if ($registro_exitoso) {

            header("Location: ../index.php");
            exit();
        } else {

            header("Location: ../register.php?error=" . urlencode(ERROR_REGISTRO_GENERAL));
            exit();
        }
    } catch (mysqli_sql_exception $e) {
 
        if ($e->getCode() == 1062) {
 
            $mensaje_error = 'La cédula o el nombre de usuario ya existen.';
        } else {
  
            $mensaje_error = 'Ha ocurrido un error inesperado.';
        }

        header("Location: ../register.php?error=" . urlencode($mensaje_error));
        exit();
    }
} else {

    header("Location: ../register.php");
    exit();
}
?>

