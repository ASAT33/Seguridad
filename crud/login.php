<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
require_once('../class/functions.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $obj_funciones = new funciones();
    $login_success = $obj_funciones->verificar_login($username, $password);

    if ($login_success) {
        $_SESSION['username'] = $username;
        header("Location: ../presentacion.php");
        exit();
    } else {
          header("Location: ../index.php?error=1");
        exit();
    }
} else {

    header("Location: ../index.php");
    exit();
}
?>

       