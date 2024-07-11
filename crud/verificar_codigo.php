<?php
session_start();

// Verifica si ha pasado más de 3 minutos desde que se generó el código de verificación
if (isset($_SESSION['verification_code_time']) && time() - $_SESSION['verification_code_time'] > 180) {
    header("Location: verificar_codigo.php?error=2");
    exit();
}

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

    header("Location: ../index.php");
    exit();
}
?>
