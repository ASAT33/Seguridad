<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_code = $_POST['verification_code'];
    $session_code = $_SESSION['verification_code'];

    if ($input_code == $session_code) {
        header("Location: ../presentacion.php");
        exit();
    } else {
        header("Location: verificar_codigo.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
